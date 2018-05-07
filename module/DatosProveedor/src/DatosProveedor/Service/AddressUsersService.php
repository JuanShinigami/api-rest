<?php 
namespace DatosProveedor\Services;

use DatosProveedor\Model\AddressUsersModel;

class AddressUsersService
{
	private $addressUsersModel;
	
	// Instanciamos el modelo de direcciones
	public function getAddressUsersModel()
	{
		return $this->addressUsersModel = new AddressUsersModel();
	}
	
	// Obtemos las direcciones
	public function fetchAll()
	{
		$states = $this->getAddressUsersModel()->fetchAll();
		return $states;
	}
	
	// Agregamos direccion
	public function addAddress($data)
	{
		$address = $this->getAddressUsersModel()->addAddress($data);
		return $address;
	}

	/**
	 * MODIFICAR UNA DIRECCION 
	 */
	public function updateAddress($data)
	{
		//echo "Modificar direccion";
		//echo "<pre>"; print_r($data); exit;

		// Datos de la direccion
		$dataAddress = array(
			'id_users' 	=> $data['id_users'],
			'state_id' 		=> $data['state_of_mexico'],
			'district' 		=> $data['district'],
			'neighborhood' 	=> $data['neighborhood'],
			'street' 		=> $data['street'],
			'number' 		=> $data['number_exterior'],
			'postalcode' 	=> $data['postal_code']
		);
		//echo "<pre>"; print_r($dataAddress); exit;

		// Modificar proveedor
		$updateAddress = $this->getAddressUsersModel()->updateAddress($dataAddress);
		//echo "<pre>"; print_r($updateAddress); exit;

		return $updateAddress;

	}
	
}