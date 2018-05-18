<?php
namespace Supplier\Service;

use Supplier\Model\SupplierModel;
use DatosProveedor\Services\AddressService;
use Supplier\Service\CompanyTypePetService;
use Supplier\Service\CompanySectorActivityService;
use Supplier\Service\CompanyNoticeService;
use DatosProveedor\Service\UsersService;

class SupplierServiceOriginal
{
	private $supplierModel;
	private $addressService;
	private $companyTypePetService;
	private $companySectorActivityService;
	private $companyNoticeService;
	private $userService;

	// Instanciamos el model
	private function getSupplierModel()
	{
		return $supplierModel = new SupplierModel();
	}

	// Instanciamos servicio de usuarios
	private function getUserService()
	{
		return $this->userService = new UsersService();
	}

	// Instanciamos servicio de direccion
	private function getAddressService()
	{
		return $addressService = new AddressService();
	}

	// Instanciamos servicio de company type pet
	private function getCompanyTypePetService()
	{
		return $this->companyTypePetService = new CompanyTypePetService();
	}

	// Instanciamos servicio de company sector activity
	private function getCompanySectorActivityService()
	{
		return $this->companySectorActivityService = new CompanySectorActivityService();
	}

	// Instanciamos servicio de company notice
	private function getCompanyNoticeService()
	{
		return $this->companyNoticeService = new CompanyNoticeService();
	}

	// Obtener todos los registros
	public function fetchAll()
	{
		$rows = $this->getSupplierModel()->fetchAll();

		return $rows;
	}


	// https://stackoverflow.com/questions/33749069/display-two-tables-data-in-php
	// Obtener todos los registros por filtro
	public function fetchAllByFilter($formData)
	{
		//echo "<pre>"; print_r($formData); exit;

		// Obtenemos los registros
		$rows = $this->getSupplierModel()->fetchAllByFilter($formData);
		//echo "<pre>"; print_r($rows); exit;

		// Arreglo para almacenar el resultado
		$new_result = array();

		// Recorremos los datos obtenidos del query
		foreach ($rows as $key => $value) {
			//print_r(empty($new_result[$value['id_company']]));
			
			// Validamos si elindice en el arreglo esta definido
			if(empty($new_result[$value['id_company']]))
			{
				// Agregamos datos al arreglo
				$new_result[$value['id_company']] = array(
					'id_company' 		=> $value['id_company'],
					'name_company' 		=> $value['name_company'],
					'company_description' => $value['company_description'],
					'website_company' 	=> $value['website'],
					'id_address' 		=> $value['id_address'],
					'state_id' 			=> $value['state_id'],
					'district' 			=> $value['district'],
					'neighborhood' 		=> $value['neighborhood'],
					'street' 			=> $value['street'],
					'number' 			=> $value['number'],
					'postalcode' 		=> $value['postalcode'],
					'name_state' 		=> $value['name_state'],
					'name_district' 	=> $value['name_district'],
					'imgs_company' 		=> array(
						array(
							'id_img' 	=> $value['id_img'],
							'img_name' 	=> $value['img_name'],
							'img_desc' 	=> $value['img_desc']
						)
					)
				);
			} else {
				//$new_result[$value['id_company']]['id_company'] 		= $value['id_company'];
				//$new_result[$value['id_company']]['name_company'] 		= $value['name_company'];
				//$new_result[$value['id_company']]['website_company'] 	= $value['website'];
				$new_result[$value['id_company']]['imgs_company'][] 	= array(
						'id_img' 	=> $value['id_img'],
						'img_name' 	=> $value['img_name'],
						'img_desc' 	=> $value['img_desc']
				);
			}
			//echo "-";
			//print_r(empty($new_result[$value['id_company']]));
			//echo "<br>";
		}

		//echo "<pre>"; print_r($new_result);
		//exit;
		$new_result = array_values($new_result);

		return $new_result;
	}

	// Obtener proveedor por id
	public function getSupplierById($idUser)
	{
		$getSupplier 	= $this->getSupplierModel()->getSupplierById($idUser);

		// Arreglo para almacenar el resultado
		$new_result 	= array();

		// Recorremos los datos obtenidos del query
		foreach ($getSupplier as $key => $value) {
			//print_r(empty($new_result[$value['id_company']]));
			
			// Validamos si elindice en el arreglo esta definido
			if(empty($new_result[$value['id_company']]))
			{
				// Agregamos datos al arreglo
				$new_result[$value['id_company']] = array(
					'id_company' 			=> $value['id_company'],
					'name_company' 			=> $value['name_company'],
					'company_description' 	=> $value['company_description'],
					'website' 				=> $value['website'],
					'id_address' 			=> $value['id_address'],
					'street' 				=> $value['street'],
					'postalcode' 			=> $value['postalcode'],
					'number' 				=> $value['number'],
					'state_id' 				=> $value['state_id'],
					'district' 				=> $value['district'],
					'neighborhood' 			=> $value['neighborhood'],
					'email' 				=> $value['email'],
					'profile' 				=> $value['profile'],
					'id_user' 				=> $value['id_user'],
					'name' 					=> $value['name'],
					'surname' 				=> $value['surname'],
					'phone' 				=> $value['phone'],
					'imgs_company' 		=> array(
						array(
							'id_img' 	=> $value['id_img'],
							'img_name' 	=> $value['img_name'],
							'img_desc' 	=> $value['img_desc']
						)
					)
				);
			} else {
				$new_result[$value['id_company']]['imgs_company'][] 	= array(
						'id_img' 	=> $value['id_img'],
						'img_name' 	=> $value['img_name'],
						'img_desc' 	=> $value['img_desc']
				);
			}
			//echo "-";
			//print_r(empty($new_result[$value['id_company']]));
			//echo "<br>";
		}

		$new_result = array_values($new_result);
		
		return $new_result;
	}

	// Obtener proveedor por id
	public function getSupplierByIdCompany($idComapny)
	{
		$getSupplier 	= $this->getSupplierModel()->getSupplierByIdCompany($idComapny);

		// Arreglo para almacenar el resultado
		$new_result 	= array();

		// Recorremos los datos obtenidos del query
		foreach ($getSupplier as $key => $value) {
			//print_r(empty($new_result[$value['id_company']]));
			
			// Validamos si elindice en el arreglo esta definido
			if(empty($new_result[$value['id_company']]))
			{
				// Agregamos datos al arreglo
				$new_result[$value['id_company']] = array(
					'id_company' 			=> $value['id_company'],
					'name_company' 			=> $value['name_company'],
					'company_description' 	=> $value['company_description'],
					'website' 				=> $value['website'],
					'id_address' 			=> $value['id_address'],
					'street' 				=> $value['street'],
					'postalcode' 			=> $value['postalcode'],
					'number' 				=> $value['number'],
					'state_id' 				=> $value['state_id'],
					'district' 				=> $value['district'],
					'neighborhood' 			=> $value['neighborhood'],
					'name_state' => $value['name_state'],
					'name_district' => $value['name_district'],
					'name_neighborhood' => $value['name_neighborhood'],
					'email' 				=> $value['email'],
					'profile' 				=> $value['profile'],
					'id_user' 				=> $value['id_user'],
					'name' 					=> $value['name'],
					'surname' 				=> $value['surname'],
					'phone' 				=> $value['phone'],
					'imgs_company' 		=> array(
						array(
							'id_img' 	=> $value['id_img'],
							'img_name' 	=> $value['img_name'],
							'img_desc' 	=> $value['img_desc']
						)
					)
				);
			} else {
				$new_result[$value['id_company']]['imgs_company'][] 	= array(
						'id_img' 	=> $value['id_img'],
						'img_name' 	=> $value['img_name'],
						'img_desc' 	=> $value['img_desc']
				);
			}
		}

		$new_result = array_values($new_result);
		
		return $new_result;
	}


	// Agregar proveedor
	public function addSupplier($data)
	{
		return;
	}

	/**
	 * MODIFICAR UN PROVEEDOR
	 */
	public function updateSupplier($data)
	{
		//echo "<pre>"; print_r($data); exit;

		// Datos del proveedor
		$dataSupplier = array(
			//'id_users'             => $addUser,
			'id_company' 			=> $data['id_company'],
			'name_company'	        => $data['name_company'],
			'company_description'   => $data['company_description'],
			'website'               => $data['website']
		);
		//echo "<pre>"; print_r($dataSupplier); exit;

		// 1 MODIFICAR PROVEEDOR
		$updateSupplier = $this->getSupplierModel()->updateSupplier($dataSupplier);
		//echo "<pre>"; print_r($updateSupplier); exit;

		// VALIDAMOS SI EL PROVEEDOR SE MODIFICO CORRECTAMENTE
		if($updateSupplier) {

			// 2 MODIFICAR DETALLE DE USUARIO
			$updateUserDetail 	= $this->getUserService()->updateUserDetail($data, $data['id']);
			//echo "<pre>"; print_r($updateUserDetail); exit;

			// 3 MODIFICAR LA DIRECCION
			$updateAddress 		= $this->getAddressService()->updateAddress($data);

			// Tipos de mascotas
			$typePets 			= json_decode($data['pet_type_checkbox'], true);
			//echo "<pre>"; print_r($typePets); exit;

			// VALIDAR SI SELECCIONARON TIPOS DE MASCOTAS
			if(count($typePets) > 0) {

				// 4 MODIFICAR company type pet
				$updateCompanyTypePet = $this->getCompanyTypePetService()->editCompanyTypePet($typePets);
				//echo "<pre>"; print_r($updateCompanyTypePet); exit;

			}

			// Sectores de actividad
			$sectorActivity 	= json_decode($data['sector_activity_checkbox'], true);
			//echo "<pre>"; print_r($sectorActivity); exit;

			// VALIDAR SI SELECCIONARON SECTORES DE ACTIVIDAD
			if(count($sectorActivity) > 0) {

				// 5 MODIFICAR company sector activity
				$updateCompanySectorActivity = $this->getCompanySectorActivityService()->editCompanySectorActivity($sectorActivity);
				//echo "<pre>"; print_r($updateCompanySectorActivity); exit;

			}

			// Numero de anuncios por compania
			$numberCompanyNotice = 6;

			// Recorremos el numero de veces de las imagenes
			for ($i=1; $i <= $numberCompanyNotice  ; $i++) {

				// Datos para las imagenes
				$dataCompanyNotice[] = array(
					'id' 			=> $data['id_img_' . $i] ,
					'description' 	=> $data['img_desc_' . $i]
				);

				// Validamos si se eligio una imagen
				if(isset($data['img_' . $i]['tmp_name']) && $data['img_' . $i]['tmp_name'] != "") {

					// Nombre de imagen
					$nameImg 			= $data['id_img_' . $i];

					// Creamos imagen
					$reziseSupplierImg 	= $this->resizeSupplierNotice($data['img_' . $i], $nameImg);
					//echo "<pre>"; print_r($reziseSupplierImg); exit;

					// Agregamos un campo al arreglo de datos
					$dataCompanyNotice[$i-1]['name'] = $reziseSupplierImg;

				}

			}
			//echo "<pre>"; print_r($dataCompanyNotice); exit;

			// 6 MODIFICAR ANUNCIOS DE PROVEEDOR
			$editCompanyNotice = $this->getCompanyNoticeService()->editCompanyNotice($dataCompanyNotice);

		}

		return $updateSupplier;

	}

	/*
	 * CREAR IMAGEN DE PROVEEDOR
	 */
	private function resizeSupplierNotice($img_supplier, $nameImg)
	{
		// Ruta donde se almacenaran las imagenes
		$path_img	= "./public/images/supplier/";

		//print_r(file_exists($path_img . $nameImg)); exit();

		// Validamos si existe la imagen
		if (file_exists($path_img . $nameImg)) {
		    //eliminando img
			unlink($path_img . $nameImg);
		}

		// Nombre final de la imagen
		$full_image_name	= sha1($nameImg);
		//echo "<pre>"; print_r($full_image_name); exit;

		// DATOS DE LA IMAGEN
		$name_image  = $img_supplier['name'];
		$tmp_image   = $img_supplier['tmp_name'];
		$type_image  = $img_supplier['type'];
		$size_image  = $img_supplier['size'];

		$final_image = 0;

		// VALIDAR SI EXISTE LA IMAGEN
		if ( isset( $img_supplier ) && !empty( $name_image ) && !empty( $tmp_image ) ){

			//indicamos los formatos que permitimos subir a nuestro servidor
		   if (($type_image == "image/gif") || ($type_image == "image/jpeg") || ($type_image == "image/jpg") || ($type_image == "image/png")) {

			   	//Definir tamaño máximo y mínimo
				$max_ancho 			= 800;
				$max_alto			= 800;

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
				$calidad = 100;

				imagejpeg($lienzo, $path_img . $full_image_name . ".jpg", $calidad);
				
				// Retornamos nombre de la imagen
				$final_image = $full_image_name . ".jpg";

   			}

		} 

		return $final_image;
	}

}