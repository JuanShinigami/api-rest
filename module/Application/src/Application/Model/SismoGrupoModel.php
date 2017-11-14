<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class SismoGrupoModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'sismogrupo';
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
			->columns(array('id', 'ubicacion', 'fecha', 'hora', 'participantes', 'idUsuarios'))
			->from(array('s' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	

	public function addSismoGrupo($dataSismoGrupo){
		
		$sql = new Sql($this->dbAdapter);
		$insertar = $sql->insert('sismogrupo');
		$array=array(
			
			'ubicacion'=>$dataSismoGrupo["ubicacion"],
			'fecha'=>$dataSismoGrupo["fecha"],
			'hora'=>$dataSismoGrupo["hora"],
			'participantes'=>$dataSismoGrupo["participantes"],
			'idUsuarios'=>$dataSismoGrupo["idUsuarios"]
		);
		print_r($array);
		exit;
		$insertar->values($array);
		$selectString = $sql->getSqlStringForSqlObject($insertar);
		$results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		print_r($results);
		exit;
		return $results;

	}
	
}
?>