<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Filter\Null;

class RecuperarFolioModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'usuarios';
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
			->columns(array('id', 'folio' , 'nombre', 'telefono', 'correo'))
			->from(array('u' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	public function existe($folioNuevo){
// 	    $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where folio = '" . $folioNuevo."'" ,Adapter::QUERY_MODE_EXECUTE);
	   
	    $res=$consulta->toArray();
	    print_r($res);
	    
	   exit;
	     	    
	    return $res;
	}
	
	public function addUsuarios($dataUser,$folioNuevo){

	        
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert('usuarios');
	        
	        $array=array(
	            
	            'folio'=>$folioNuevo,
	            'nombre'=>$dataUser["nombre"],
	            'telefono'=>$dataUser["telefono"],
	            'correo'=>$dataUser["correo"]
	        );
	        
	        $insertar->values($array);
	        
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	        print_r($array);
 	 }
 	    
 	    
 	    
 	 public function updateUsuarios($usuario,$folioNuevo){
 	     
 	     print_r($usuario[0]['id']);
 	    
 	   
	        $sql = new Sql($this->dbAdapter);
	        $update = $sql->update();
	        $update->table('usuarios');
	        
	        $array=array(
	            
	            'folio'=>$folioNuevo
	        );
	        
	        $update->set($array);
	        $update->where(array('id' => $usuario[0]['id']));
	        
	        $selectString = $sql->getSqlStringForSqlObject($update);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	        print_r($array);
 	 }
	

}

?>






