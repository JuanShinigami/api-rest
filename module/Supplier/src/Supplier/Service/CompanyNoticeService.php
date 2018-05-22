<?php
namespace Supplier\Service;

use Supplier\Model\CompanyNoticeModel;

class CompanyNoticeService
{

	private $companyNoticeModel;

	/*
	* Instanciar modelo de company notice
	*/
	private function getCompanyNoticeModel()
	{
		return $this->companyNoticeModel = new CompanyNoticeModel();
	}

	/*
	* Obtener anuncios de compania
	*/
	public function getCompanyNoticeById($idCompany)
	{
		$companyNotice = $this->getCompanyNoticeModel()->getCompanyNoticeById($idCompany);

		return $companyNotice;
	}

	/*
	* Agregar anuncios de compania
	*/
	public function addCompanyNotice($data, $idCompany)
	{
		// Recorremos los datos
		foreach ($data as $row) {

			// Datos
			$dataCN[] =array(
				'id_company' 	=> $idCompany,
				'name' 			=> $row['name'],
				'description' 	=> $row['description']
			);

		}
		//echo "<pre>"; print_r($dataCN); exit;

		$addCompanyNotice = $this->getCompanyNoticeModel()->addCompanyNotice($dataCN);

		return $addCompanyNotice;
	}

	/*
	* Editar anuncios de compania
	*/
	public function editCompanyNotice($data)
	{
		//echo "Modificar company notice";
		//echo "<pre>"; print_r($data); exit;

		$editCompanyNotice = $this->getCompanyNoticeModel()->editCompanyNotice($data);
		//echo "<pre>"; print_r($editCompanyNotice); exit;

		return $editCompanyNotice;
	}

}