<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Update;
use Zend\Filter\Null;

class UsuarioModel extends TableGateway
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
	
	public function addUsuarios($dataUser){
		
	    
// 	    print_r($dataUser['nombre']);


	    $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $res=$consulta->toArray();
	    
	    print_r($res);
	    
	    if (empty($res[0]['id'])){
	        
	       // print_r($res);
	        
	        $folioExtrae = substr($dataUser['nombre'],0,2);
	        $folioNuevo=$folioExtrae . 100;
	        echo "Extrae ".$folioExtrae;
	       echo "\n";
	        echo "folioNuevo ".$folioNuevo;
	        
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
	        
	    }else {
	        
	        $folioExtrae = substr($res[0]['folio'],2);
	        echo "Extracion ".$folioExtrae."\n";
	        $folioAct=$folioExtrae + 100;
	        echo "Suma ". $folioAct;
	        $folioNuevo=substr($dataUser['nombre'],0,2). $folioAct;
	        echo" \n";
	        echo "folio Actualizado ".$folioNuevo;
	        
	        $sql = new Sql($this->dbAdapter);
	        $update = $sql->update();
	        $update->table('usuarios');
	        
	        $array=array(
	            
	            'folio'=>$folioNuevo
	        );
	        
	        $update->set($array);
	        $update->where(array('id' => $res[0]['id']));
	        
	        $selectString = $sql->getSqlStringForSqlObject($update);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	    }
	    
	}

}

?>






