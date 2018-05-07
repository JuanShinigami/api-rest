<?php
namespace DatosProveedor\Services;

use DatosProveedor\Model\AddressModel;

class AddressService
{
	private $addressModel;
	
	// Instanciamos el modelo de direcciones
	public function getAddressModel()
	{
		return $this->addressModel = new AddressModel();
	}
	
	// Obtemos las direcciones
	public function fetchAll()
	{
		$states = $this->getAddressModel()->fetchAll();
		return $states;
	}
	
	// Agregamos direccion
	public function addAddress($data)
	{
		$address = $this->getAddressModel()->addAddress($data);
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
			'company_id' 	=> $data['id_company'],
			'state_id' 		=> $data['state_of_mexico'],
			'district' 		=> $data['district'],
			'neighborhood' 	=> $data['neighborhood'],
			'street' 		=> $data['street'],
			'number' 		=> $data['number_exterior'],
			'postalcode' 	=> $data['postal_code']
		);
		//echo "<pre>"; print_r($dataAddress); exit;

		// Modificar proveedor
		$updateAddress = $this->getAddressModel()->updateAddress($dataAddress);
		//echo "<pre>"; print_r($updateAddress); exit;

		return $updateAddress;

	}
	
}