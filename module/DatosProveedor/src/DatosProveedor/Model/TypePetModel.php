<?php
namespace DatosProveedor\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class TypePetModel extends TableGateway
{
	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'pet_type';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
   	}
	
   	/* Todas los estados*/
	public function fetchAll()
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->from(array('t_p' => $this->table))
			->order('t_p.order_pet ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}
	
	public function addArticulo($articulo){
	    $insert = $this->insert(array(
	        "type" => $articulo,
	        "registration_date"=> date("Y-m-d H:i:s"),
	        "registration_update"=> date("Y-m-d H:i:s")
	    ));
	    return $insert;
	}
	public function getArticulo($id){
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select->columns(array('articulo' =>'type'))
	    ->from($this->table)
	    ->where(array('id' => $id));
	    
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result=$execute->toArray();
	    return $result[0];
	}
	
	public function updateArticulo($id,$articulo){
	    $update=$this->update(array(
	        "type"    => $articulo
	    ),
	        array("id"=>$id));
	    return $update;
	}
	
	/* Borrar dato*/
	public function deleteById($id)
	{
	    return $this->delete(array("id"=>$id));
	}
}