<?php
namespace DatosProveedor\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class AddressUsersModel extends TableGateway
{
	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'addresses_users';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
   	}
	
   	// Todas las direccones
	public function fetchAll()
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->from(array('s' => $this->table))
			->order('s.state ASC'); 
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}
	
	// Agregar direccion
	public function addAddress($data)
	{
		$connection = null;
	
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
	
			/* Ejecutar una o mas consultas aqui */
			$address     = $this->insert($data);
			$saveAddress = $this->getLastInsertValue();
			$connection->commit();
		}
		catch (\Exception $e) {
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			// Tratamiento de errores
			$saveAddress = $e->getCode();
		}
	
		return $saveAddress;
	}
	
	/**
	 * MODIFICAR UNA DIRECCION
	 */
	public function updateAddress($data)
	{
		//echo "Modificar direccion MODEL"; exit();

		$connection = null;
		
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
		
			// Ejecutar una o mas consultas aqui
			$address     	= $this->update($data, array("id_users" => $data['id_user']));
			$updateAddress 	= $data['id_user'];
			$connection->commit();
		}
		catch (\Exception $e) {
			

			// Tratamiento de errores
			$updateAddress = $dataErrors;
		}

		return $updateAddress;

	}
}