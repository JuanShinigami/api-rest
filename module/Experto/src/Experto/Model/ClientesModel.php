<?php
namespace Experto\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ClientesModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'clientes';
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
			->columns(array('id', 'nombre','correo', 'contrasena'))
			->from(array('c' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function addCliente($dataCliente){
// 		print_r($dataCliente);exit;
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        
// 	        print_r($dataPerfil["perfil"]);exit;
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert($this->table);
	        $array=array(
	          
	            'nombre'=>$dataCliente["nombre"],
	            'correo'=>$dataCliente["correo"],
	            'contrasena'=>$dataCliente["contrasena"]
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
	
	
	
	public function eliminarClientes($dataPartCliente){
	    
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $delete = $sql->delete($this->table);
	        $delete->where(array('id' => $dataPartCliente));
	        
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
	
	public function existe($cliente)
	{
	    
// 	    print_r($cliente['correo']);exit;
// 	     $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta = $this->dbAdapter->query("select * FROM clientes where correo = '" . $cliente['correo'] . "'", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    // echo "res ";
// 	    print_r($res);
	    
	    return $res;
	}
	
	public function idCliente()
	{
	    
	    // 	    print_r($cliente['correo']);exit;
	    // 	     $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta = $this->dbAdapter->query("select max(id) as id FROM clientes", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    // echo "res ";
// 	    	    print_r($res);exit;
	    
	    return $res;
	}
	
	public function buscarCliente($id) {
	    
	    $sql = new Sql($this->dbAdapter);
	    $select = $sql->select();
	    $select
	    ->columns(array('nombre', 'correo', 'contrasena'))
	    ->from(array('c' => $this->table))
	    ->where(array('id'=>$id));
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