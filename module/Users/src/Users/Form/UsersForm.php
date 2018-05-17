<?php 

namespace Users\Form;

use Zend\Form\Form;
use DatosProveedor\Services\StatesService;
//use Application\Services\PetService;
use DatosProveedor\Services\TypePetService;
use DatosProveedor\Services\PetActivitySectorService;
use DatosProveedor\Model\TypePetModel;
use DatosProveedor\Model\PetActivitySectorModel;
use DatosProveedor\Model\StatesModel;

class UsersForm extends Form
{
	
	public function __construct($name = null){

		parent::__construct($name);
		
		$this->setAttributes(array(
				'action'=>"",
				'method' => 'post'
		));

		$this->add(array(
				'name' => 'id',
				'type' => 'Hidden'
		));

		// ID DE SUPPLIER
		$this->add(array(
				'name' => 'id_company',
				'type' => 'Hidden'
		));

		$this->add(array(
				'name' => 'campus',
				'type' => 'Text',
				/*'options' => array(
						'label' => 'Nombre o Razon social:',
				),*/
				'attributes' => array(
						'id' => 'campus',
						'class'       => 'validate',
						//'placeholder' => 'Nombre',
						//'required'    => 'required',
						//'data-validetta' => 'required',
						//'data-vd-message-required'=>"Por favor ingrese su campus!"
				)
		));

		// campo brand para proveedor

		$this->add(array(
				'name' => 'brand',
				'type' => 'Text',
				/*'options' => array(
						'label' => 'Nombre o Razon social:',
				),*/
				'attributes' => array(
						'id' => 'brand',
						'class'       => 'validate',
						//'placeholder' => 'Nombre',
						//'required'    => 'required',
						//'data-validetta' => 'required',
						//'data-vd-message-required'=>"Por favor ingrese su campus!"
				)
		));

		/*********** DATOS DE ACCESO ***********/

		// Correo electronico
		$this->add(array(
				'name' => 'email_user',
				'type' => 'text',
				'attributes' => array(
						'id' => 'email_user',
						'class'       => 'validate',
						//'required'    => 'required',
						'data-validetta' => 'required, email',
						'data-vd-message-required' => "Por favor ingrese un correo electronico"
				)
		));

		// Repetir correo electronico
		$this->add(array(
				'name' => 'repeat_email_user',
				'type' => 'text',
				'attributes' => array(
						'id' => 'repeat_email_user',
						'class'       => 'validate',
						//'required'    => 'required',
						'data-validetta' => 'required, email',
						'data-vd-message-required' => "Por favor ingrese nuevamente el correo electronico"
				)
		));

		// Contraseña
		$this->add(array(
				'name' => 'password_user',
				'type' => 'password',
				'attributes' => array(
						'id' => 'password_user',
						'class'       => 'validate',
						//'required'    => 'required',
						'data-validetta' => 'required',
						'data-vd-message-required' => "Por favor ingrese una contraseña"
				)
		));

		// Repetir contraseña
		$this->add(array(
				'name' => 'repeat_password_user',
				'type' => 'password',
				'attributes' => array(
						'id' => 'repeat_password_user',
						'class'       => 'validate',
						//'required'    => 'required',
						'data-validetta' => 'required',
						'data-vd-message-required' => "Por favor ingrese nuevamente la contraseña"
				)
		));

		/*********** DATOS PERSONALES / CONTACTO ***********/

		// Nombre
		$this->add(array(
			'name' => 'name_user',
			'type' => 'Text',
			'attributes' => array(
				'id' => 'name_user',
				'class'       => 'validate',
				'data-validetta' => 'required',
				'data-vd-message-required' => "Por favor ingrese un nombre"
			)
		));

		// Apellido paterno
		$this->add(array(
			'name' => 'surname',
			'type' => 'Text',
			'attributes' => array(
				'id' => 'surname',
				'class'       => 'validate',
				'data-validetta' => 'required',
				'data-vd-message-required' => "Por favor ingrese un apellido"
			)
		));

		// Telefono
		$this->add(array(
			'name' => 'phone',
			'type' => 'number',
			'attributes' => array(
				'id' => 'phone',
				'class'       => 'validate',
				'data-validetta' => 'required',
				'data-vd-message-required' => "Por favor ingrese un número de teléfono"
			)
		));

		// Sitio web
		$this->add(array(
			'name' => 'website',
			'type' => 'Text',
			'attributes' => array(
				'id' => 'website',
				//'class'       => 'validate',
				//'data-validetta' => 'required',
				//'data-vd-message-required' => "Por favor ingrese un sitio web"
				)
		));

		/*********** DATOS DE EMPRESA ***********/

		// Nombre de la empresa
		$this->add(array(
			'name' => 'name_company',
			'type' => 'Text',
			'attributes' => array(
				'id' => 'name_company',
				'class'       => 'validate',
				'data-validetta' => 'required',
				'data-vd-message-required' => "Por favor ingrese el nombre de la empresa"
			)
		));

		// Descripcion de la empresa
		$this->add(array(
			'name' => 'company_description',
			'type' => 'TextArea',
			'attributes' => array(
				'id' => 'company_description',
				'class'       => 'validate materialize-textarea',
				//'data-validetta' => 'required',
				//'data-vd-message-required' => "Por favor ingrese la descripción de la empresa"
			)
		));

		/*********** DATOS DE BUSQUEDA ***********/

		// TIPO DE MAASCOTA
		$this->add(array(
			'name' => 'pet_type',
			'type' => 'Select',
			'options' => array(
				'label' => 'Tipo mascota',
				'empty_option' => 'seleccione',
				'value_options' => $this->getAllPetType()
			),
			'attributes' => array(
				'id' => 'pet_type',
				'class' => ''
			)
		));

		// SECTOR DE ACTIVIDAD
		$this->add(array(
			'name' => 'sector_activity',
			'type' => 'Select',
			'options' => array(
				'label' => 'Sector de actividad',
				'empty_option' => 'seleccione',
				'value_options' => $this->getAllActivitySector()
			),
			'attributes' => array(
				'id' => 'sector_activity',
				'class' => ''
			)
		));

		/*********** DATOS DE DIRECCION ***********/

		// CALLE
		$this->add(array(
			'name' 	=> 'street',
			'type' 	=> 'Text',
			'attributes' => array(
				'id' => 'street',
				'class' => '',
			)
		));

		// NUMERO EXTERIOR
		$this->add(array(
			'name' => 'number_exterior',
			'type' => 'Text',
			'attributes' => array(
				'id' => 'number_exterior',
				'class' => ''
			)
		));

		// ESTADO
		$this->add(array(
			'name' => 'state_of_mexico',
			'type' => 'Select',
			'options' => array(
				'label' => 'Estado',
				'empty_option' => 'seleccione',
				'value_options' => $this->getAllStatesOfMexico()
			),
			'attributes' => array(
				'id' => 'state_of_mexico',
				'class' => ''
			)
		));

		// DELEGACION O MUNICIPIO
		$this->add(array(
			'name' => 'district',
			'type' => 'Select',
			'options' => array(
				'label' => 'Delegación o municipio',
				'empty_option' => 'seleccione'
			),
			'attributes' => array(
				'id' => 'district',
				'class' => ''
			)
		));

		// COLONIA
		$this->add(array(
			'name' => 'neighborhood',
			'type' => 'Select',
			'options' => array(
				'label' => 'Colonia',
				'empty_option' => 'seleccione'
			),
			'attributes' => array(
				'id' => 'neighborhood',
				'class' => ''
			)
		));

		// CODIGO POSTAL
		$this->add(array(
			'name' => 'postal_code',
			'type' => 'Text',
			'options' => array(
				'label' => 'Codigo postal'
			),
			'attributes' => array(
				'id' => 'postal_code',
				'class' => '',
				'readonly' => false
			)
		));

		// BOTON REGISTRATE
		$this->add(array(
				'name' => 'btn_register',
				'type' => 'Submit',
				'attributes' => array(
						'value' => 'Regístrate ahora',
						'id'    => 'btn_register',
						'class' => 'waves-effect waves-light btn-large pink col s12 m6 l6 offset-m3 offset-l3',
				),
		));

	}

	// Obtener todos los estados de mexico
	private function getAllStatesOfMexico()
	{
// 		$statesService 	= new StatesService();
		$statesService 	= new StatesModel();
		$statesOfMexico = $statesService->fetchAll();
		//echo "<pre>"; print_r($statesOfMexico); exit;
		$result 		= array();

		// Reecorrer datos
		foreach($statesOfMexico as $state) {
			$result[$state['id']] = $state['state'];
		}

		return $result;
	}

	// Obtener los tipos de mascotas
	private function getAllPetType()
	{
// 		$typePetService 	= new TypePetService();
	    $typePetService 	= new TypePetModel();
		$typePet 			= $typePetService->fetchAll();
		$result 			= array();

		// Reecorrer datos
		foreach($typePet as $type) {
			$result[$type['id']] = $type['type'];
		}

		return $result;
	}

	// Obtener los sectores de actividad
	private function getAllActivitySector()
	{
// 		$sectorActivityService 	= new PetActivitySectorService();
	    $sectorActivityService 	= new PetActivitySectorModel();
		$sectorActivity 		= $sectorActivityService->fetchAll();
		$result 				= array();

		// Recorrer datos
		foreach ($sectorActivity as $key => $sector) {
			$result[$sector['id']] = $sector['sector'];
		}

		return $result;
	}

}