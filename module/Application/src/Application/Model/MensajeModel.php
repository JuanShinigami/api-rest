<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class MensajeModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'mensajes';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
	}

	/**
	* OBTEMOS TODOS los imeis
	*/
	public function getAll()
	{
		$sql = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id', 'mensajeCreador' , 'idSismogrupo'))
			->from(array('m' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addMensaje($dataMensaje){
		
	    $flag = false;
	    $respuesta = array();
	    try {
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert('mensajes');
	        $array=array(
	            
	            'mensajeCreador'=>$dataMensaje["mensajeCreador"],
	            'idSismogrupo'=>$dataMensaje["idSismogrupo"]
	        );
	        //		print_r($array);
	        //		exit;
	        $insertar->values($array);
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	    }
	    catch (\PDOException $e) {
	        //echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        //echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;

		return $results;
		
	}
	
	public function buscarMensaje($id) {
	    
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('id', 'mensajeCreador' , 'idSismogrupo'))
	    ->from(array('m' => $this->table))
	    ->where(array('idSismogrupo'=>$id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    //print_r($selectString); exit;
	    $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result       = $execute->toArray();
	    //echo "<pre>"; print_r($result); exit;
	    
// 	    print_r($result);
	    return $result;;
	    	    
	}
	
	

}
?>