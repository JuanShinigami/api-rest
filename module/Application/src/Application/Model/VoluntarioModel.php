<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class VoluntarioModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'voluntario';
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
			->columns(array('id', 'alias'))
			->from(array('p' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function existe($dataVoluntario)
	{
	    
	    // print_r($folioNuevo);
	    // $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta = $this->dbAdapter->query("select id , alias FROM voluntario where id = '" . $dataVoluntario['id'] . "'", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    // echo "res ";
// 	    print_r($res);
// 	    exit;
	    
	    return $res;
	}
	public function addVoluntario($dataVoluntario){
	    
	    $flag = false;
	    $respuesta = array();
	    
	    
	    try {
	    	$sql = new Sql($this->dbAdapter);
	    	$insertar = $sql->insert('voluntario');
		    $array=array(
		        'id'=>$dataVoluntario["id"],
		        'alias'=>$dataVoluntario["alias"]
		    );
	    //		print_r($array);
	    //		exit;
		    $insertar->values($array);
		    $selectString = $sql->getSqlStringForSqlObject($insertar);
	    	$results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	    	$flag = true;
	    	//echo "BIEN";
	    }catch (\PDOException $e) {
        	//echo "First Message " . $e->getMessage() . "<br/>";
        	$flag = false;
    	}catch (\Exception $e) {
        	//echo "Second Message: " . $e->getMessage() . "<br/>";
    	}
    	$respuesta['status'] = $flag;
	    //echo print_r($results->toArray());
	    
	    //$results = $execute->toArray();
	   
	    return $respuesta;
	    
	}

}
?>