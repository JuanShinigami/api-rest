<?php
namespace Experto\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class RecomendacionesModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'recomendaciones';
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
			->columns(array('id', 'recomendacion','idRecords'))
			->from(array('c' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addRecomendacion($dataRecomendacion){
// 		print_r($dataCliente);exit;
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        
// 	        print_r($dataPerfil["perfil"]);exit;
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert($this->table);
	        $array=array(
	            
	            'recomendacion'=>$dataRecomendacion["recomendacion"],
	            'idRecords'=>$dataRecomendacion["idRecords"]
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
	
	
	
	public function editarRecomendacion($dataRecomendacion){
// 	    print_r($dataPartRecords);exit;
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $update = $sql->update();
	        $update->table($this->table);
	        
	        $array = array(
	            
	            'recomendacion'=>$dataRecomendacion["recomendacion"],
	        );
	        
	        $update->set($array);
	        $update->where(array(
	            'idRecords'=>$dataRecomendacion["idRecords"]
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
	
	public function buscarRecomendacion($id) {
// 	    print_r($id);
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('id', 'recomendacion','idRecords'))
	    ->from(array('c' => $this->table))
	    ->where(array('idRecords'=>$id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    //print_r($selectString); exit;
	    $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result       = $execute->toArray();
	    //echo "<pre>"; print_r($result); exit;
	    
// 	    	    print_r($result);exit;
	    return $result;;
	    
	}
	
	public function eliminarRecomendacion($dataRecomendacion){
	    
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $delete = $sql->delete($this->table);
	        $delete->where(array('idRecords' => $dataRecomendacion));
	        
	        $selectString = $sql->getSqlStringForSqlObject($delete);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	        // $consulta=$this->dbAdapter->query("DELETE FROM participante_sismo_grupo where idSismo = '" . $dataPartSismo["idSismo"]."'" ,Adapter::QUERY_MODE_EXECUTE);
	        // 	        $res=$consulta->toArray();
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
	
	

}
?>