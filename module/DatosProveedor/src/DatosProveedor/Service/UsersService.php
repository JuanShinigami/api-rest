<?php
namespace DatosProveedor\Service;

use DatosProveedor\Model\UsersModel;
use DatosProveedor\Services\AddressService;
use DatosProveedor\Services\AddressUsersService;
use Supplier\Service\CompanyNoticeService;
use Supplier\Service\CompanySectorActivityService;
use Supplier\Service\CompanyTypePetService;
use Zend\Crypt\Password\Bcrypt;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Exception;

const TYPE_USER_COMPANY = '3';

class UsersService
{
	private $usersModel;
	private $addressService;
	private $companyTPService;
	private $companySAService;
	private $companyNoticeService;
	private $addressUsersService;

	/**
	 * Obtenemos una instancia del modelo
	 */
	private function getUsersModel()
	{
		return $this->usersModel = new UsersModel();
	}

	/**
	 * Obtenemos una instancia del servicio de direcciones
	 */
	private function getAddressUsersService()
	{
		return $this->addressUsersService = new AddressUsersService();
	}

	/**
	 * Obtenemos una instancia del servicio de direcciones
	 */
	private function getAddressService()
	{
		return $this->addressService = new AddressService();
	}

	/**
	 * Obtenemos una instancia del servicio de company type pet
	 */
	private function getCompanyTypePetService()
	{
		return $this->companyTPService = new CompanyTypePetService();
	}

	/**
	 * Obtenemos una instancia del servicio de company sector activity
	 */
	private function getCompanySectorActivityService()
	{
		return $this->companySAService = new CompanySectorActivityService();
	}

	/**
	 * Obtenemos una instancia del servicio de company notice
	 */
	private function getCompanyNoticeService()
	{
		return $this->companyNoticeService = new CompanyNoticeService();
	}

	/**
	 * OBTEMOS DATOS DE USUARIO
	 */
	public function getAll($idUser)
	{
		$perfil = $this->getUsersModel()->getAll($idUser);

		return $perfil;
	}

	// Modificar detalle de usuario
	public function updateUserDetail($data, $idUser)
	{
		//echo "Modificar detalle de usuario"; exit();
		//echo "<pre>"; print_r($data); exit;

		// Datos de user detail
		$dataUserDetail = array(
				'id_user'  	=> $idUser,
				'name'  	=> $data['name_user'],
				'surname' 	=> $data['surname'],
				'phone'   	=> $data['phone']
		);
		//echo "<pre>"; print_r($dataUserDetail); exit;

		// Agregamos detalle de un usuario
		$updateUserDetail = $this->getUsersModel()->editusersDetails($dataUserDetail);
		//echo "<pre>"; print_r($updateUserDetail); exit;

		return $updateUserDetail;
	}

	/**
	 * Metodo para agregar un usuario
	 */
	public function addUsers($data)
	{
		//echo "<pre>"; print_r($data); exit;

		// Encriptamos la contrasena
		$securityPass = $this->bcryptPassSecurity($data['password_user']);
		

		// Arreglo de datos
		$dataUser = array(
			'correo'    => $data['correo_usuario'],
			'contrasena' => $securityPass,			
			'perfil'   => $data['type_user']
		);

		//echo "<pre>"; print_r($dataUser); exit;

		// Agregamos un usuario
		$addUser = $saveUsers = $this->getUsersModel()->addUsers($dataUser);
		//echo "<pre>"; print_r($addUser); exit;

		// Validamos si ya se guardaron los datos
		if ($addUser) {

			// Encriptamos la contrasena
			//$securityKey = ($data['key_inventory'] != "") ? $this->bcryptPassSecurity($data['key_inventory']) : "";
			
			// Encriptamos el pin
			//$securityPin = ($data['pin'] != "") ? $this->bcryptPassSecurity($data['pin']) : "";

			// Arreglo de datos
			$dataUserDetails = array(
				'id'       => $addUser,
				'nombre'          => $data['nombre_usuario'],
				//**********'surname'       => $data['surname'],
				//'campus'        => $data['campus'],
				//'key_inventory' => $securityKey,
				//'pin'           => $securityPin,
				//*****'phone'         => $data['phone']
			);
			//echo "<pre>"; print_r($dataUserDetails); exit;
			// Agregamos detalle de un usuario
			$addUserDetails = $this->getUsersModel()->addUsersDetails($dataUserDetails);

			// VALIDAR SI ES PERSONA O PROVEEDOR
			if($data['type_user'] == TYPE_USER_COMPANY) {

				// Llamamos funcion para crear compania
				$addCompany = $this->createAndSaveCompany($data, $addUser);

			}else {

			$addAdressUser = $this->createAndSaveAddressUsers($data, $addUser);
			//echo "<pre>"; print_r($addAdressUser); exit;
		}

		}		

		return $addUser;
	}

	/**
	 * AGREGAR UNA DIRECCION PARA USUARIOS
	 */
	private function createAndSaveAddressUsers($data, $addUser)
	{
		// Arreglo de datos
		$dataAddress = array(
			'id_users'  	=> $addUser,
			//'street'		=> $data['street'],
			'postalcode'  	=> $data['postal_code'],
			//'number'      	=> $data['number_exterior'],
			'state_id'	  	=> $data['state_of_mexico'],
			'district'  	=> $data['district'],
			'neighborhood' 	=> $data['neighborhood']
		);

		// Agregamos direccion
		$addAddress = $this->getAddressUsersService()->addAddress($dataAddress);

		return $addAddress;
	}


	/**
	 * CREAR Y AGREGAR UNA COMPANIA
	 */
	private function createAndSaveCompany($data, $addUser)
	{
		//echo "<pre>"; print_r($data); exit;

		// Arreglo de datos
		$dataCompany = array(
			'id_users'             => $addUser,
			'name_company'	       => $data['name_company'],
			'company_description'  => $data['company_description'],
			'website'              => $data['website']
		);
		//echo "<pre>"; print_r($dataCompany); exit;

		// Agregamos
		$addCompany = $this->getUsersModel()->addCompany($dataCompany);
		//echo "<pre>"; print_r($addCompany); exit;

		// Validamos si se agrego la compania
		if ($addCompany) {
			
			// Creamos la direccion
			$addAddress = $this->createAndSaveAddress($data, $addCompany);

			// Creamos contacto
			//$addContact = $this->createAndSaveContact($data, $addCompany);

			$typePets = json_decode($data['pet_type_checkbox'], true);
			//echo "<pre>"; print_r($typePets); exit;

			// Agregar company type pet
			$companyTypePet = $this->getCompanyTypePetService()->addCompanyTypePet($typePets, $addCompany);
			//echo "<pre>"; print_r($companyTypePet); exit;

			// Agregar company sector activity
			$sectorActivity = json_decode($data['sector_activity_checkbox'], true);
			
			// Agregar company sector activity
			$addCompanySectorActivity = $this->getCompanySectorActivityService()->addCompanySectorActivity($sectorActivity, $addCompany);

			// Numero de anuncios por compania
			$numberCompanyNotice = 6;

			for ($i=1; $i <= $numberCompanyNotice  ; $i++) {
				// Datos para las imagenes
				$dataCompanyNotice[] = array(
					'id_company'	=> $addCompany,
					'name' 			=> '',//$data['image_one'],
					'description' 	=> ''//$data['description_image_one']
				);
			}
			//echo "Company Notice";
			//echo "<pre>"; print_r($dataCompanyNotice); exit;

			// Datos de anuncios de la compania
			/*$dataCompanyNotice = array(
				array(
					'id_company' 				=> $daddCompany,
					'image_one' 				=> $data['image_one'],
					'description_image_one' 	=> $data['description_image_one']
				),
				array(
					'id_company' 				=> $daddCompany,
					'image_two' 				=> $data['image_two'],
					'description_image_two' 	=> $data['description_image_two']
				),
				array(
					'id_company' 				=> $daddCompany,
					'image_three' 				=> $data['image_three'],
					'description_image_three' 	=> $data['description_image_three']
				),
				array(
					'id_company' 				=> $daddCompany,
					'image_four' 				=> $data['image_four'],
					'description_image_four' 	=> $data['description_image_four']
				),
				array(
					'id_company' 				=> $daddCompany,
					'image_five' 				=> $data['image_five'],
					'description_image_five' 	=> $data['description_image_five']
				),
				array(
					'id_company' 				=> $daddCompany,
					'image_six' 				=> $data['image_six'],
					'description_image_six' 	=> $data['description_image_six']
				)
			);*/

			// Agregar anuncios de la compania
			$addCompanyNotice = $this->getCompanyNoticeService()->addCompanyNotice($dataCompanyNotice, $addCompany);
			//echo "<pre>"; print_r($addCompanyNotice); exit;
		}

		return $addCompany;
	}

	/**
	 * AGREGAR UNA DIRECCION
	 */
	private function createAndSaveAddress($data, $addCompany)
	{
		// Arreglo de datos
		$dataAddress = array(
			'company_id'  	=> $addCompany,
			'street'		=> $data['street'],
			'postalcode'  	=> $data['postal_code'],
			'number'      	=> $data['number_exterior'],
			'state_id'	  	=> $data['state_of_mexico'],
			'district'  	=> $data['district'],
			'neighborhood' 	=> $data['neighborhood']
		);

		// Agregamos direccion
		$addAddress = $this->getAddressService()->addAddress($dataAddress);

		return $addAddress;
	}

	/**
	 * AGREGAR UN CONTACTO
	 */
	private function createAndSaveContact($data, $addCompany)
	{
		// Datos a guardar
		$dataContact = array(
			'company_id' 		=> $addCompany,
			'name_contact' 		=> $data['name_user'],
			'surname_contact' 	=> $data['surname'],
			'phone' 			=> $data['phone']
		);

		// Agregar Contacto
		$addContact = $dataContact;

		return $addContact;
	}

	/**
	 * Metodo para validar si un email ya existe
	 */
	public function verifyEmailExists($email)
	{
		//print_r($email); exit;
		$emailFull = array('email' => $email);

		$verifyEmail = $this->getUsersModel()->verifyEmailExists($emailFull);

		return $verifyEmail;
	}

	/**
	 * Metodo para encriptar la contraseña
	 */
	private function bcryptPassSecurity($pass)
	{
		$bcrypt = new Bcrypt(array(
			'salt' => '$2y$05$KkFmCjGPJiC1jdt.SFcJ5uDXkF1yYCQFgiQIjjT6p.z7QIHyU1elW',
			'cost' => 5
		));
		
		// Contrasena segura
		$securePass = $bcrypt->create(strip_tags($pass));

		return $securePass;
	}

/**
	 * OBTENER DATOS DE USUARIO POR ID
	 */
	public function getPerfilById($id)
	{

		$perfil = $this->getUsersModel()->getPerfilById($id);

		return $perfil;
	}


	/**
	 * MODIFICAR UN ARTICULO
	 */
	public function editPerfil($data)
	{
		//echo "<pre>"; print_r($data); exit;

		$redimensionarImgPerfi = 0;

		// ($data['image']['tmp_name'] != "")
		if (isset($data['image']['tmp_name']) && $data['image']['tmp_name'] != "") {
			// REDIMENSIONAR IMAGEN 1
			$redimensionarImgPerfi    = $this->redimensionarImagenPerfil($data['image']['tmp_name']);
		}


		//echo "<pre>"; print_r(base64_encode($redimensionarImgPerfi)); exit;

		// Encriptamos la contrasena
		//$securityPass = $this->bcryptPassSecurity($data['password_user']);

		// Arreglo de datos
		$dataUser = array(
			//'email'    => $data['email_user'],
			//'password' => $securityPass
			
		);

		//echo "<pre>"; print_r($dataUser);

		// Agregamos un usuario
		//$editUser = $saveUsers = $this->getUsersModel()->editusersDetails($dataUser);
		//echo "<pre>"; print_r($addUser);

		// Validamos si ya se guardaron los datos
		//if ($editUser) {

			// Arreglo de datos
			$dataUserDetails = array(
				'id_user'       => $data['id'],
				'name'          => $data['name'],
				'surname'       => $data['surname'],
				'campus'        => $data['campus'],
				'phone'         => $data['phone'],
				'addres'        => $data['addres'],
				//'pin'           => $data['pin'],
				//'key_inventory' => $data['key_inventory'],
				//'image'       => ($redimensionarImgPerfil) ? base64_encode($redimensionarImgPerfil) : ''
			);

			
			// Validamos si existe la imagen
		if ($redimensionarImgPerfi) {
			$dataUserDetails['image'] = base64_encode($redimensionarImgPerfi);

		}
		
		//echo "<pre>"; print_r($dataUserDetails); exit;

			// Agregamos un usuario
			$addUserDetails = $this->getUsersModel()->editusersDetails($dataUserDetails);

			//echo "<pre>"; print_r($addUserDetails); exit;

		//}		

		return $addUserDetails;
	}


	/**
	 * MODIFICAR UN PERFIL DE PROVEEDOR
	 */
	public function editPerfilprovider($data)
	{
		//echo "<pre>"; print_r($data); exit;

		$redimensionarImgPerfi = 0;

		// ($data['image']['tmp_name'] != "")
		if (isset($data['image']['tmp_name']) && $data['image']['tmp_name'] != "") {
			// REDIMENSIONAR IMAGEN 1
			$redimensionarImgPerfi    = $this->redimensionarImagenPerfil($data['image']['tmp_name']);
		}


		//echo "<pre>"; print_r(base64_encode($redimensionarImgPerfi)); exit;

		// Encriptamos la contrasena
		//$securityPass = $this->bcryptPassSecurity($data['password_user']);

		// Arreglo de datos
		$dataUser = array(
			//'email'    => $data['email_user'],
			//'password' => $securityPass
			
		);

		//echo "<pre>"; print_r($dataUser);


			// Arreglo de datos
			$dataUserDetails = array(
				'id_user'       => $data['id'],
				'name'          => $data['name'],
				'phone'         => $data['phone'],
				/*'website'       => $data['website'],
				'name_company'  => $data['name_company'],
				'company_description'  => $data['company_description'],*/
				//'pin'           => $data['pin'],
				//'key_inventory' => $data['key_inventory'],
				//'image'       => ($redimensionarImgPerfil) ? base64_encode($redimensionarImgPerfil) : ''
			);

			
			// Validamos si existe la imagen
		if ($redimensionarImgPerfi) {
			$dataUserDetails['image'] = base64_encode($redimensionarImgPerfi);

		}		
		//echo "<pre>"; print_r($dataUserDetails); exit;
			// Agregamos un usuario
			$addUserDetails = $this->getUsersModel()->editusersDetails($dataUserDetails);

			//echo "<pre>"; print_r($addUserDetails); exit;

		//}		

		return $addUserDetails;
	}


	/**
	 * MODIFICAR PERFIL APP MOVIL
	 */
	public function editProfileAppMovil($data)
	{
		//echo "<pre>"; print_r($data); exit;

		// Arreglo de datos
		$dataUserDetails = array(
			'id_user'       => $data['id'],
			'name'          => $data['name'],
			'surname'       => $data['surname'],
			'campus'        => $data['campus'],
			'phone'         => $data['phone'],
			//'addres'        => $data['addres'],
			//'pin'           => $data['pin'],
			//'key_inventory' => $data['key_inventory'],
		);

		// VALIDAMOS SI VIENE IMAGEN
		if($data['image'] != "") {
			$dataUserDetails['image'] = $data['image'];
		}
		
		//echo "<pre>"; print_r($dataUserDetails); exit;

		// Agregamos un usuario
		$editUserDetails = $this->getUsersModel()->editusersDetails($dataUserDetails);

		//echo "<pre>"; print_r($addUserDetails); exit;		

		return $editUserDetails;
	}

	/**
	 * GENERAR IMAGEN DE PROVEEDORES
	 */
	private function redimensionarImagenProveedor($img_provider, $id_company, $no_image = null)
	{
		// Ruta donde se almacenaran las imagenes
		$path_images	= "./public/images/provider/";

		// OBTENEMOS EL NOMBRE ACTUAL DE LA IMAGEN
		$nameImgCurrent	= $this->getNameImageProvider($id_code_qr);
		//echo "<pre>"; print_r($nameImgCurrent); exit;

		// VALIDAR SI EXISTE UN NOMBRE DE IMAGEN
		if (count($nameImgCurrent) > 0) {
			// VALIDAR EL NUMERO DE IMAGEN
			if ($no_image == 1) {
				// COMPROBAR SI EL NOMBRE DE LA IMG 1 NO ESTA VACIO
				if($nameImgCurrent[0]['image_name'] != "") {
					$nImg = $nameImgCurrent[0]['image_name'];

					if (file_exists($path_images.$nImg)) {
					    //eliminando del servidor
						unlink($path_images . $nImg);
					}
				}
			} else if ($no_image == 2) {
				// COMPROBAR SI EL NOMBRE DE LA IMG 2 NO ESTA VACIO
				if($nameImgCurrent[0]['image_name_two'] != "") {
					
					$nImg2 = $nameImgCurrent[0]['image_name_two'];

					if (file_exists($path_images.$nImg2)) {
					    //eliminando del servidor
						unlink($path_images . $nImg2);
					}
				}
			}
		}

		// MARCA DE TIEMPO
		$timeStampImg = strtotime("now");
		//echo "<pre>"; print_r($timeStampImg); exit;

		// Nombre final de la imagen
		$full_image_name	= "prov-" . $timeStampImg . "-" . $no_image;
		//echo "<pre>"; print_r($full_image_name); exit;

		// DATOS DE LA IMAGEN
		$name_image  = $img_provider['name'];
		$tmp_image   = $img_provider['tmp_name'];
		$type_image  = $img_provider['type'];
		$size_image  = $img_provider['size'];

		$final_image = 0;

		// VALIDAR SI EXISTE LA IMAGEN
		if ( isset( $img_provider ) && !empty( $name_image ) && !empty( $tmp_image ) ){

			//indicamos los formatos que permitimos subir a nuestro servidor
		   if (($type_image == "image/gif") || ($type_image == "image/jpeg") || ($type_image == "image/jpg") || ($type_image == "image/png")) {

			   	//Definir tamaño máximo y mínimo
				$max_ancho 			= 300;
				$max_alto			= 300;

		   		// Validar el tipo de extesion de la imagen
		   		switch ($type_image) {
		   			case 'image/gif':

		   				$img_original	= imagecreatefromgif($tmp_image);

		   				break;
		   			case 'image/jpeg':
		   				
		   				$img_original	= imagecreatefromjpeg($tmp_image);

		   				break;

		   			case 'image/jpg':

		   				$img_original	= imagecreatefromjpeg($tmp_image);
		   				
		   				break;

		   			case 'image/png':
		   				
		   				$img_original	= imagecreatefrompng($tmp_image);

		   				break;
		   			
		   			default:
		   				
		   				break;
		   		}

		   		//Recoger ancho y alto de la original
				list($ancho,$alto) = getimagesize($tmp_image);

				//Calcular proporción ancho y alto
				$x_ratio = $max_ancho / $ancho;
				$y_ratio = $max_alto / $alto;

				if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
					//Si es más pequeña que el máximo no redimensionamos
		    		$ancho_final = $ancho;
		    		$alto_final  = $alto;
				}
				//si no calculamos si es más alta o más ancha y redimensionamos
				elseif ( ($x_ratio * $alto) < $max_alto ){
		    		$alto_final  = ceil($x_ratio * $alto);
		   			$ancho_final = $max_ancho;
				}
				else{
		    		$ancho_final = ceil($y_ratio * $ancho);
		    		$alto_final  = $max_alto;
				}

				//Crear lienzo en blanco con proporciones
				$lienzo = imagecreatetruecolor($ancho_final,$alto_final);

				//Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
				imagecopyresampled($lienzo,$img_original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);

				//Limpiar memoria
				imagedestroy($img_original);

				//Definimos la calidad de la imagen final
				$calidad = 90;

				imagejpeg($lienzo, $path_images . $full_image_name . ".jpg", $calidad);
				
				// Retornamos nombre de la imagen
				$final_image = $full_image_name . ".jpg";

   			}

		} 

		return $final_image;

	}

	/**
	 * OBTENER NOMBRE DE UNA IMAGEN DE PROVEEDOR
	 */
	private function getNameImageProvider($idQr)
	{
		$nameImage = $this->getArticlesModel()->getNameImageProvider($idQr);

		return $nameImage;
	}

	private function redimensionarImagenPerfil($img_perfil)
	{

		//echo "<pre>"; print_r(is_uploaded_file($img_article)); exit;
		/*$file_tempname = null;
		if (is_uploaded_file($img_article)) {
		    $file_tempname = $img_article;
		}
		else{
		    exit('Wrong file type');
		}

		$file_dimensions = getimagesize($file_tempname);
		$file_type = strtolower($file_dimensions['mime']);
		echo "<pre>"; print_r($file_type);exit;
		if ($file_type=='image/jpeg' || $file_type=='image/pjpeg'){
		    if(imagecreatefromjpeg($file_tempname)){
		        $im = imagecreatefromjpeg($file_tempname);
		        return $im;	
		    } 
		}
		echo "<pre>"; print_r($file_type);exit;*/
		try {

			//Ruta de la original
			$rtOriginal = $img_perfil;

			//Crear variable de imagen a partir de la original
			$original   = imagecreatefromjpeg($rtOriginal);
			
			//echo "<pre>"; print_r($original); exit;
			//Definir tamaño máximo y mínimo
			$max_ancho = 300;
			$max_alto  = 300;

			//Recoger ancho y alto de la original
			list($ancho,$alto) = getimagesize($rtOriginal);

			//Calcular proporción ancho y alto
			$x_ratio = $max_ancho / $ancho;
			$y_ratio = $max_alto / $alto;

			if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){
				//Si es más pequeña que el máximo no redimensionamos
	    		$ancho_final = $ancho;
	    		$alto_final = $alto;
			}
			//si no calculamos si es más alta o más ancha y redimensionamos
			elseif (($x_ratio * $alto) < $max_alto){
	    		$alto_final  = ceil($x_ratio * $alto);
	   			$ancho_final = $max_ancho;
			}
			else{
	    		$ancho_final = ceil($y_ratio * $ancho);
	    		$alto_final = $max_alto;
			}

			//Crear lienzo en blanco con proporciones
			$lienzo = imagecreatetruecolor($ancho_final,$alto_final);

			//Copiar $original sobre la imagen que acabamos de crear en blanco ($tmp)
			imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);

			//Limpiar memoria
			imagedestroy($original);

			//Definimos la calidad de la imagen final
			$cal = 90;

			ob_start();

			// Se crea la imagen final en el directorio indicado
			// "./data/imagenesresize/thumb.jpg"
			imagejpeg($lienzo,NULL,$cal);

			$final_image = ob_get_contents();

			ob_end_clean();

		} catch (Exception $e) {
			$final_image = 0;
    		//echo 'Excepción capturada: ',  $e->getMessage(), "\n"; exit;
		}
 
		//echo "<pre>"; print_r($final_image); exit;
		return $final_image;
	}



	private function rescalarimagen($img_perfil)
	{
		//BASADO EN JPEG, PARA USAR EN PNG, GIF ETC CAMBIAR EL NOMBRE DE LAS FUNCIONES

		//if (isset($_FILES['imagen1']) && $_FILES['imagen1']['tmp_name']!=''){

		//Imagen original
		//$rtOriginal=$_FILES['imagen1']['tmp_name'];
		$rtOriginal = $img_perfil;

		//Crear variable
		$original = imagecreatefromjpeg($rtOriginal);

		//Ancho y alto máximo
		$max_ancho = 600; $max_alto = 400;
 
		//Medir la imagen
		list($ancho,$alto)=getimagesize($rtOriginal);

		//Ratio
		$x_ratio = $max_ancho / $ancho;
		$y_ratio = $max_alto / $alto;

		//Proporciones
		if(($ancho <= $max_ancho) && ($alto <= $max_alto) ){
		    $ancho_final = $ancho;
		    $alto_final = $alto;
		}
		else if(($x_ratio * $alto) < $max_alto){
		    $alto_final = ceil($x_ratio * $alto);
		    $ancho_final = $max_ancho;
		}
		else {
		    $ancho_final = ceil($y_ratio * $ancho);
		    $alto_final = $max_alto;
		}

		//Crear un lienzo
		$lienzo=imagecreatetruecolor($ancho_final,$alto_final); 

		//Copiar original en lienzo
 		imagecopyresampled($lienzo,$original,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto);
 
		//Destruir la original
		imagedestroy($original);

		ob_start();

		//Crear la imagen y guardar en directorio upload/
		//imagejpeg($lienzo,"upload/".$_FILES['imagen1']['name']);
		imagejpeg($lienzo);

		 $i = ob_get_clean();

		//}
		$full_img = base64_encode( $i );
		return  $full_img;
	}

	private function resize($image) {
		// $image is the uploaded image
  		list($width, $height) = getimagesize($image);
  		
  		//setup the new size of the image
  		$ratio      = $width/$height;
  		$new_height = 500;
  		$new_width  = $new_height * $ratio;

  		//move the file in the new location
  		//move_uploaded_file($image['tmp_name'], $target_file);
 
  		// resample the image       
  		$new_image = imagecreatetruecolor($new_width, $new_height);

  		$old_image = imagecreatefromjpeg($image);

  		imagecopyresampled($new_image,$old_image,0,0,0,0,$new_width, $new_height, $width, $height);       

  		ob_start();
  		//output
  		imagejpeg($new_image, null, 100);
  		$i = ob_get_clean();

		//}
		$full_img = base64_encode( $i );
		return  $full_img;
}

	/**
	 * METODO PARA VALIDAR LA CLAVE DE SESION
	 */
	public function verifyKeyPass($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);

		$verifyKeyPass = $this->getUsersModel()->verifyKeyPass($securityPass, $idUser);

		return $verifyKeyPass;
	}

	/**
	 * METODO PARA CAMBIAR LA CONTRASEÑA DE SESION
	 */
	public function updateKeyPass($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);

		$updateKeyPass = $this->getUsersModel()->updateKeyPass($securityPass, $idUser);

		return $updateKeyPass;
	}

	/**
	 * METODO PARA CAMBIAR EMAIL
	 */
	public function updateKeyEmail($email, $idUser)
	{
		// Encriptamos la contraseña
		//$securityPass = $this->($email);

		$updateEmail = $this->getUsersModel()->updateEmail($email, $idUser);

		return $updateEmail;
	}

	/**
	 * METODO PARA CAMBIAR LA CONTRASEÑA DE INVENTARIO
	 */
	public function updateKeyPassinventory($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);

		$updateKeyPassinventory = $this->getUsersModel()->updateKeyPassinventory($securityPass, $idUser);

		return $updateKeyPassinventory;
	}

	/**
	 * METODO PARA VALIDAR LA CLAVE DEL INVENTARIO
	 */
	public function verifyKeyPassinventory($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);
		//echo "<pre>"; print_r($securityPass); exit;

		$verifyKeyPassinventory = $this->getUsersModel()->verifyKeyPassinventory($securityPass, $idUser);

		return $verifyKeyPassinventory;
	}

	/**
	 * METODO PARA VALIDAR EL PIN
	 */
	public function verifyKeyPin($key, $idUser)
	{
		// Encriptamos el pin
		$securityPass = $this->bcryptPassSecurity($key);

		// VERIFICAR EL PIN
		$verifyKeyPin = $this->getUsersModel()->verifyKeyPin($securityPass, $idUser);

		return $verifyKeyPin;
	}

	/**
	 * METODO PARA CAMBIAR PIN
	 */
	public function updateKeyPin($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);

		$updateKeyPin = $this->getUsersModel()->updateKeyPin($securityPass, $idUser);

		return $updateKeyPin;
	}
		
	/**
	 * METODO PARA VALIDAR EL PIN DEL USUARIO
	 */
	public function verifyPinUser($pin, $idUser)
	{
		// Encriptamos la contraseña
		$securityPin = $this->bcryptPassSecurity($pin);
		//echo "<pre>"; print_r($securityPin); exit;

		$verifyPinUser = $this->getUsersModel()->verifyPinUser($securityPin, $idUser);

		return $verifyPinUser;
	}

	/**
	 * METODO AGREGAR UN DISPOSITIVO DEL USUARIO
	 */
	public function insertTokenPush($token, $idUser, $osType)
	{
		$tokenDevice = $this->getUsersModel()->insertTokenPush($token, $idUser, $osType);
		return $tokenDevice;
	}

	/**
	 * ENVIAR CORREO ELECTRONICO AL CONTACTO
	 */
	public function sendEMailkeyinvento($email_user)
	{
		//echo "<pre>"; print_r(trim($data['email_owner'])); exit;
		//OBTENER CORREO DEL DUENO DEL ARTICULO

		$message = new Message();
		$message->addTo(trim($email_user['email_p']))
		  ->addFrom('noreply@pegalinas.com')
		  ->setSubject('Recuperación de contraseña de seguridad');
		  
		// Setup SMTP transport using LOGIN authentication
		$transport = new SmtpTransport();
		$options   = new SmtpOptions(array(
		  'name' => 'smtp.gmail.com',
		  'host' => 'smtp.gmail.com',
		  'port' => 587, // Notice port change for TLS is 587
		  'connection_class' => 'plain',
		  'connection_config' => array(
		      'username' => 'noreply@pegalinas.com',
		      'password' => 'swuetDefBek6',
		      'ssl' => 'tls',
		  ),
		));

		$messageEmail = 
		//echo "<pre>"; print_r($messageEmail); exit;

		'<div class="row">
				<div style="background-color: #E6E6E6;padding-left: 40px;padding-right: 40px;padding-top: 2px;padding-bottom: 2px;">
					<div class="col s8"
						style="border-radius: 28px 28px 28px 28px; -moz-border-radius: 28px 28px 28px 28px; -webkit-border-radius: 28px 28px 28px 28px; border: 2px solid #57585A; -webkit-box-shadow: 0px 0px 23px 8px rgba(0, 0, 0, 0.75); -moz-box-shadow: 0px 0px 23px 8px rgba(0, 0, 0, 0.75); box-shadow: 0px 0px 23px 8px rgba(0, 0, 0, 0.75);">
						<div class="row">

							<div class="col s4"
								style="border-radius: 28px 28px 0px 0px; -moz-border-radius: 28px 28px 0px 0px; -webkit-border-radius: 28px 28px 0px 0px; background-color: #ffffff;">
								<center>
								<div style="padding: 20px;">
									<a href="#"><img style="pointer-events: none; max-width:100%; " alt="pegalinas recupera"
										src="https://2.bp.blogspot.com/-xJpntXf0Ey8/WPkTQAjTekI/AAAAAAAABFY/e-pXWWKejFoZHEn9JcX5lcIgbRWfgF7GwCLcB/s320/Recupera%2Bby%2Bpegalinas.png" /></a>
								</div>
									
									<h1 style="color: black;">  </h1>
								</center>

								<div
									style="padding-left: 40px; padding-right: 40px; color: black;">
									
								<center><h2> ¡Hola! </h2></center>
						           <h3>Detectamos que olvidaste tu contraseña de seguridad.</h3>
				                  <h3>Hemos generado una nueva contraseña para ti.</h3>
				                  <h3>Tu nueva contraseña es: <font color="red">'.$email_user['key_inventory'] .'</font></h3>		                 
				                  <h4>Podrás modificarla en tu perfil o puedes conservarla si así lo deseas.</h4>
				                  

								</div>
								<br>
							</div>
							<div class="col s4"
								style="border-radius: 0px 0px 28px 28px; -moz-border-radius: 0px 0px 28px 28px; -webkit-border-radius: 0px 0px 28px 28px; background-color: white;">
								<center>
									<a href="https://www.youtube.com/channel/UCnzEiknp5FrTbw3zAUaNpjg" target="_blank"><img alt="youtube"
										src="http://icon-icons.com/icons2/70/PNG/64/youtube_14198.png" /></a>
									<a href="https://twitter.com/pegalinas" target="_blank"><img alt="twitter"
										src="http://icon-icons.com/icons2/642/PNG/64/twitter_2_icon-icons.com_59206.png" /></a>
									<a href="https://www.facebook.com/RecuperaMx/" target="_blank"><img alt="facebook"
										src="http://icon-icons.com/icons2/91/PNG/64/facebook_16423.png" /></a>
									
									
								</center>
							</div>
						</div>
					</div>
				</div>
			</div>
		';
		//$html = new MimePart('<b>heii, <i>sorry</i>, i\'m going late</b>');
		$html = new MimePart($messageEmail);
		$html->type = "text/html";

		$body = new MimeMessage();
		$body->addPart($html);

		$message->setBody($body);

		$transport->setOptions($options);
		$transport->send($message);

		return "Mensaje Enviado";
	}

	/**
	 * METODO PARA CAMBIAR CONTRASEÑA DE INVENTARIO
	 */
	public function updatekey_inventory($key, $idUser)
	{
		// Encriptamos la contraseña
		$securityPass = $this->bcryptPassSecurity($key);

		$updatekey_inventory = $this->getUsersModel()->updatekey_inventory($securityPass, $idUser);

		return $updatekey_inventory;
	}


	

}
