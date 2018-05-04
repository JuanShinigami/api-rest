<?php
namespace Supplier\Service;

use Supplier\Model\CompanyTypePetModel;

class CompanyTypePetService
{
	private $companyTypePetModel;
	
	// Instanciamos el modelo
	public function getCompanyTypePetModel()
	{
		return $this->companyTypePetModel = new CompanyTypePetModel();
	}
	
	// Obtemos todos los registros
	public function fetchAll()
	{
		$company_type_pet = $this->getCompanyTypePetModel()->fetchAll();
		return $company_type_pet;
	}

	// Obtener tipos de mascota por id de proveedor
	public function getCompanyTypePetById($idCompny)
	{
		$companyTypePet = $this->getCompanyTypePetModel()->getCompanyTypePetById($idCompny);

		return $companyTypePet;
	}
	
	// Agregar
	public function addCompanyTypePet($data, $company)
	{
		// Recorremos los datos
		foreach ($data as $row) {
			$dataCTP[] =array(
				'id_company' 	=> $company,
				'id_type_pet' 	=> $row['id'],
				'status' 		=> $row['status']
			);	
		}
		//echo "<pre>"; print_r($dataCTP); exit;

		$addCompanyTypePet = $this->getCompanyTypePetModel()->addCompanyTypePet($dataCTP);

		return $addCompanyTypePet;
	}

	// Editar
	public function editCompanyTypePet($data)
	{
		//echo "Modificar company type pet"; exit();
		//echo "<pre>"; print_r($data); exit;

		// Recorremos los datos
		foreach ($data as $row) {
			$dataCTP[] =array(
				//'id_company' 	=> $company,
				//'id_type_pet' 	=> $row['id'],
				'id' 		=> $row['id'], // ID DE LA COLUMNA
				'status' 	=> $row['status']
			);	
		}
		//echo "<pre>"; print_r($dataCTP); exit;

		$editCompanyTypePet = $this->getCompanyTypePetModel()->editCompanyTypePet($dataCTP);
		//echo "<pre>"; print_r($editCompanyTypePet); exit;

		return $editCompanyTypePet;
	}
	
}