<?php
namespace Supplier\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class CompanyNoticeModel extends TableGateway
{

	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'images_company';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
   	}

   	/*
	* Obtener anuncios de compania
	*/
	public function getCompanyNoticeById($idCompany)
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id', 'id_company', 'id_type_pet', 'status'))
			->from(array('c_n' => $this->table))

			// JOIN A LA TABLA DE TYPE PET
			//->join(array('p_t' => 'pet_type'), 'c_n.id_type_pet = p_t.id', array('name_type' => 'type', 'orde_type' => 'order_pet'), 'Inner')

			//->order('p_t.order_pet ASC')
			->where(array('c_n.id_company' => $idCompny));
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	/*
	* Agregar anuncios de compania
	*/
	public function addCompanyNotice($data)
	{
		$connection = null;
	
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
	
			/* Ejecutar una o mas consultas aqui */
			foreach($data as $notice) {
				$companyNotice     = $this->insert($notice);
				$addCompanyNotice[]  = $this->getLastInsertValue();
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			$dataErrors = array(
				"code" 		=> $e->getCode(),
				"message" 	=> $e->getMessage(),
				"file" 		=> $e->getFile(),
				"line" 		=> $e->getLine()
			);

			// Tratamiento de errores
			$addCompanyNotice = $dataErrors;
		}
	
		return $addCompanyNotice;
	}

	/*
	* Editar anuncios de compania
	*/
	public function editCompanyNotice($data)
	{
		$connection = null;
		
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
		
			// Ejecutar una o mas consultas aqui
			foreach($data as $notice) {
				$companyNotice     = $this->update($notice, array("id" => $notice['id']));
				$editCompanyNotice[] = $notice['id'];
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			$dataErrors = array(
				"code" 		=> $e->getCode(),
				"message" 	=> $e->getMessage(),
				"file" 		=> $e->getFile(),
				"line" 		=> $e->getLine()
				
			);

			// Tratamiento de errores
			$editCompanyNotice = $dataErrors;
		}

		return $editCompanyNotice;
	}

}