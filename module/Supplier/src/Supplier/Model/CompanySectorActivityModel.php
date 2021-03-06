<?php
namespace Supplier\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class CompanySectorActivityModel extends TableGateway
{
	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'company_activity_sector';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
   	}
	
   	// Todos los contactos
	public function fetchAll()
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->from(array('c_a_s' => $this->table))
			->order('c_a_s.id ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	// Obtener sector de actividad por id de proveedor
	public function getCompanySectorActivityById($idCompny)
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id', 'id_company', 'id_activity_sector', 'status'))
			->from(array('c_a_s' => $this->table))

			// JOIN A LA TABLA DE SECTOR ACTIVITY
			->join(array('p_a_s' => 'pet_activity_sector'), 'c_a_s.id_activity_sector = p_a_s.id', array('name_sector' => 'sector', 'sector_order'), 'Inner')

			->order('p_a_s.sector_order ASC')
			->where(array('c_a_s.id_company' => $idCompny));
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}
	
	// Agregar
	public function addCompanySectorActivity($data)
	{
		$connection = null;
	
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
	
			/* Ejecutar una o mas consultas aqui */
			foreach($data as $ctp) {
				$companySectorActivity     = $this->insert($ctp);
				$saveCompanySectorActivity = $this->getLastInsertValue();
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			// Tratamiento de errores
			$saveCompanySectorActivity = $e->getCode();
		}
	
		return $saveCompanySectorActivity;
	}
	
	// Modificar
	public function editCompanySectorActivity($data)
	{
		//echo "<pre>"; print_r($data); exit;

		$connection = null;
		
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
		
			// Ejecutar una o mas consultas aqui
			foreach($data as $csa) {
				$companySectorActivity 			= $this->update($csa, array("id" => $csa['id']));
				$editCompanySectorActivity[] 	= $csa['id'];
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
			$editCompanySectorActivity = $dataErrors;
		}

		return $editCompanySectorActivity;

	}
}