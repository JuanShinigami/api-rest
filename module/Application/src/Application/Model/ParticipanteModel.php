<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class ParticipanteModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'participante';
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
	
	public function addParticipante($dataParticipante){
	    
	    $flag = false;
	    $respuesta = array();
	    
	    
	    try {
	    	$sql = new Sql($this->dbAdapter);
	    	$insertar = $sql->insert('participante');
		    $array=array(
		        'id'=>$dataParticipante["id"],
		        'alias'=>$dataParticipante["alias"]
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