<?php
namespace Supplier\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class CompanyTypePetModel extends TableGateway
{
	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'company_type_pet';
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
			->from(array('c_t_p' => $this->table))
			->order('c_t_p.id ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	// Obtener tipos de mascota por id de proveedor
	public function getCompanyTypePetById($idCompny)
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id', 'id_company', 'id_type_pet', 'status'))
			->from(array('c_t_p' => $this->table))

			// JOIN A LA TABLA DE TYPE PET
			->join(array('p_t' => 'pet_type'), 'c_t_p.id_type_pet = p_t.id', array('name_type' => 'type', 'orde_type' => 'order_pet'), 'Inner')

			->order('p_t.order_pet ASC')
			->where(array('c_t_p.id_company' => $idCompny));
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}
	
	// Agregar
	public function addCompanyTypePet($data)
	{
		$connection = null;
	
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
	
			/* Ejecutar una o mas consultas aqui */
			foreach($data as $ctp) {
				$companyTypePet     = $this->insert($ctp);
				$saveCompanyTypePet = $this->getLastInsertValue();
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			// Tratamiento de errores
			$saveCompanyTypePet = $e->getCode();
		}
	
		return $saveCompanyTypePet;
	}
	
	// Modificar
	public function editCompanyTypePet($data)
	{
		//echo "<pre>"; print_r($data); exit;
		$connection = null;
		
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
		
			// Ejecutar una o mas consultas aqui
			foreach($data as $ctp) {
				$companyTypePet     = $this->update($ctp, array("id" => $ctp['id']));
				$editCompanyTypePet[] = $ctp['id'];
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
			$editCompanyTypePet = $dataErrors;
		}

		return $editCompanyTypePet;

	}
}