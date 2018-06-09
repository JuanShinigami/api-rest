<?php
namespace Experto\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class RecordsModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'records';
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
			->columns(array('id', 'altitud','longitud', 'latitud','tiempo', 'tagRecords','creado','idClientes'))
			->from(array('c' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addRecords($dataCliente){
// 		print_r($dataCliente);exit;
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        
// 	        print_r($dataPerfil["perfil"]);exit;
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert($this->table);
	        $array=array(
	            
	            'altitud'=>$dataCliente["altitud"],
	            'longitud'=>$dataCliente["longitud"],
	            'latitud'=>$dataCliente["latitud"],
	            'tiempo'=>$dataCliente["tiempo"],
	            'tagRecords'=>$dataCliente["tagRecords"],
	            'creado'=>$dataCliente["creado"],
	            'idClientes'=>$dataCliente["idClientes"]
	        );
	        //		print_r($array);
	        //		exit;
	        $insertar->values($array);
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
// 	        print_r($flag);
	    }
	    catch (\PDOException $e) {
	        echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    
// 	    print_r($respuesta);exit;

		return $respuesta;
		
	}
	
	
	
	public function editarRecords($dataPartRecords){
// 	    print_r($dataPartRecords);exit;
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $update = $sql->update();
	        $update->table($this->table);
	        
	        $array = array(
	            
	            'altitud'=>$dataPartRecords["altitud"],
	            'longitud'=>$dataPartRecords["longitud"],
	            'latitud'=>$dataPartRecords["latitud"],
	            'tiempo'=>$dataPartRecords["tiempo"],
	            'creado'=>$dataPartRecords["creado"],
	        );
	        
	        $update->set($array);
	        $update->where(array(
	            'idClientes' => $dataPartRecords['idClientes'],
	            'tagRecords'=>$dataPartRecords["tagRecords"],
	        ));
	        
	        $selectString = $sql->getSqlStringForSqlObject($update);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	    }catch (\PDOException $e) {
	        //echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        //echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    
	    return $respuesta;
	    
	    
	    
	    // 	    print_r($res);
	    // 	    exit;
	    
	}
	
	
	public function existe($dataRecords)
	{
	    
// 	    print_r($dataRecords);exit;
	    $consulta = $this->dbAdapter->query("SELECT * FROM records WHERE altitud = '" . $dataRecords['altitud']."' AND longitud = '" . $dataRecords['longitud']."' AND latitud = '" . $dataRecords['latitud']."' ", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    // echo "res ";
// 	    print_r($res);exit;
	    
	    return $res;
	}
	
	public function buscarRecords($id) {
// 	    print_r($id);
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('id', 'altitud','longitud', 'latitud','tiempo', 'tagRecords','creado','idClientes'))
	    ->from(array('c' => $this->table))
	    ->where(array('idClientes'=>$id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    //print_r($selectString); exit;
	    $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result       = $execute->toArray();
	    //echo "<pre>"; print_r($result); exit;
	    
// 	    	    print_r($result);exit;
	    return $result;;
	    
	}
	
	

}
?>