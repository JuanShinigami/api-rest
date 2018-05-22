<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class PerfilModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'perfil';
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
			->columns(array('id', 'perfil'))
			->from(array('p' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addPerfil($dataPerfil){
// 		print_r($dataPerfil["perfil"]);exit;
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        
// 	        print_r($dataPerfil["perfil"]);exit;
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert('perfil');
	        $array=array(
	          
	            'perfil'=>$dataPerfil["perfil"]
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
	
	public function buscarMensaje($id) {
	    
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('id', 'mensajeCreador' , 'idSimulacrogrupo'))
	    ->from(array('m' => $this->table))
	    ->where(array('idSimulacrogrupo'=>$id));
	    $selectString = $sql->getSqlStringForSqlObject($select);
	    //print_r($selectString); exit;
	    $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    $result       = $execute->toArray();
	    //echo "<pre>"; print_r($result); exit;
	    
// 	    print_r($result);
	    return $result;;
	    	    
	}
	
	
	public function eliminaMensaje($dataPartSismo){
	    
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $delete = $sql->delete('mensajes');
	        $delete->where(array('idSimulacrogrupo' => $dataPartSismo));
	        
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
	
	public function existe($folioNuevo)
	{
	    
// 	    print_r($folioNuevo);
	    // $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta = $this->dbAdapter->query("select id , perfil FROM perfil where perfil = '" . $folioNuevo['perfil'] . "'", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    // echo "res ";
	    // print_r($res);
	    
	    return $res;
	}
	

}
?>