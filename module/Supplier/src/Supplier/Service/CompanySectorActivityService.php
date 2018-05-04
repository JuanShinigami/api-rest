<?php
namespace Supplier\Service;

use Supplier\Model\CompanySectorActivityModel;

class CompanySectorActivityService
{
	private $companySectorActivityModel;
	
	// Instanciamos el modelo
	public function getCompanySectorActivityModel()
	{
		return $this->companySectorActivityModel = new CompanySectorActivityModel();
	}
	
	// Obtemos todos los registros
	public function fetchAll()
	{
		$company_sector_activity = $this->getCompanySectorActivityModel()->fetchAll();
		return $company_sector_activity;
	}

	// Obtener sector de actividad por id de proveedor
	public function getCompanySectorActivityById($idCompny)
	{
		$companySectorActivity = $this->getCompanySectorActivityModel()->getCompanySectorActivityById($idCompny);

		return $companySectorActivity;
	}
	
	// Agregar
	public function addCompanySectorActivity($data, $company)
	{
		// Recorremos los datos
		foreach ($data as $row) {
			$dataCSA[] =array(
				'id_company' 			=> $company,
				'id_activity_sector' 	=> $row['id'],
				'status' 				=> $row['status']
			);	
		}
		//echo "<pre>"; print_r($dataCSA); exit;

		$addCompanySectorActivity = $this->getCompanySectorActivityModel()->addCompanySectorActivity($dataCSA);

		return $addCompanySectorActivity;
	}

	// Editar
	public function editCompanySectorActivity($data)
	{
		//echo "Modificar company sector activity"; exit();
		//echo "<pre>"; print_r($data); exit;

		// Recorremos los datos
		foreach ($data as $row) {
			$dataCSA[] =array(
				//'id_company' 	=> $company,
				//'id_activity_sector' 	=> $row['id'],
				'id' 		=> $row['id'], // ID DE LA COLUMNA
				'status' 	=> $row['status']
			);	
		}
		//echo "<pre>"; print_r($dataCSA); exit;

		$editCompanySectorActivity = $this->getCompanySectorActivityModel()->editCompanySectorActivity($dataCSA);
		//echo "<pre>"; print_r($editCompanySectorActivity); exit;

		return $editCompanySectorActivity;
	}
	
}