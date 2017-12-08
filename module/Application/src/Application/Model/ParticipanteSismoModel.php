<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ParticipanteSismoModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'participante_sismo_grupo';
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
			->columns(array('id', 'idParticipante', 'idSismo', 'tiempo_inicio', 'tiempo_estoy_listo'))
			->from(array('s' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	

	public function addParticipanteSismo($dataPartSismo){
	   
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert('participante_sismo_grupo');
	        $array=array(
	            
	            'idParticipante'=>$dataPartSismo["idParticipante"],
	            'idSismo'=>$dataPartSismo["idSismo"],
	            'tiempo_inicio'=>$dataPartSismo["tiempo_inicio"],
	            'tiempo_estoy_listo'=>$dataPartSismo["tiempo_estoy_listo"]
	        );
	        
	        $insertar->values($array);
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	        
	    }catch (\PDOException $e) {
	        //echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        //echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
		
// 		print_r($array);
// 		exit;
	
	    return $respuesta;

	}
	
	public function buscarDetalleParticipante($id){
	    $sql = new Sql($this->dbAdapter);
	    	    $select = $sql->select();
	    	    $select
	    	    ->from(array('t1'=>'participante_sismo_grupo'), array())
	    	    ->join(array('t2'=>'sismogrupo'), 't1.idSismo = t2.id', array('ubicacion','fecha','hora'))
	    	    ->join(array('t3'=>'participante'), 't3.id=t1.idParticipante' , array());
	    
	            	        
	            $selectString = $sql->getSqlStringForSqlObject($select);
	            	        //print_r($selectString); exit;
	            $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	            $result = $execute->toArray();
	            	        //echo "<pre>"; print_r($result); exit;
	            
	            // 	        print_r($result);
	            // 	        exit;
	            
	            	        return $result;
	}
	
}
?>