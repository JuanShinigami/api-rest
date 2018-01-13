<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class VoluntarioSimulacroModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'voluntario_simulacro_grupo';
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
			->columns(array('id', 'idVoluntario', 'idSimulacro', 'tiempo_inicio', 'tiempo_estoy_listo','mensajeParticipante'))
			->from(array('s' => $this->table));
		$selectString = $sql->getSqlStringForSqlObject($select);
		//print_r($selectString); exit;
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		//echo "<pre>"; print_r($result); exit;

		return $result;
	}
	
	

	public function addVoluntarioSimulacro($dataVolSimulacro){
	   
	    $flag = false;
	    $respuesta = array();
	    
	    try {
	        $sql = new Sql($this->dbAdapter);
	        $insertar = $sql->insert('voluntario_simulacro_grupo');
	        $array=array(
	            
	            'idVoluntario'=>$dataVolSimulacro["idVoluntario"],
	            'idSimulacro'=>$dataVolSimulacro["idSimulacro"]
// 	            'tiempo_inicio'=>$dataPartSismo["tiempo_inicio"],
// 	            'tiempo_estoy_listo'=>$dataPartSismo["tiempo_estoy_listo"],
// 	            'mensajeParticipante'=>$dataPartSismo["mensajeParticipante"]
	        );
	        
	        $insertar->values($array);
	        $selectString = $sql->getSqlStringForSqlObject($insertar);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	        
	    }catch (\PDOException $e) {
	        echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    $respuesta['idVoluntario'] = $this->existe($dataVolSimulacro)[0]['idVoluntario'];
		
// 		print_r($respuesta);
	
	    return $respuesta;

	}
	
	public function updateVoluntario($dataVolSimulacro)
	{
	    $flag = false;
	    $respuesta = array();
	    
	    
	    try {
	       
	        $sql = new Sql($this->dbAdapter);
	        $update = $sql->update();
	        $update->table('voluntario_simulacro_grupo');
	        
	        $array = array(
	            
	            'tiempo_inicio'=>$dataVolSimulacro["tiempo_inicio"],
	            'tiempo_estoy_listo'=>$dataVolSimulacro["tiempo_estoy_listo"],
	        	'mensajeVoluntario'=>$dataVolSimulacro["mensajeVoluntario"]
	        );
	        
	        $update->set($array);
	        $update->where(array(
	            'idVoluntario' => $dataVolSimulacro['idVoluntario'],
	            'idSimulacro'=>$dataVolSimulacro['idSimulacro']
	        ));
	        
	        $selectString = $sql->getSqlStringForSqlObject($update);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	    } catch (\PDOException $e) {
	        // echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    } catch (\Exception $e) {
	        // echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    return $respuesta;
	}
	
	
	public function existe($dataVolSimulacro)
	{
	    
	    // $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
	    $consulta = $this->dbAdapter->query("select id FROM voluntario_simulacro_grupo where idVoluntario = '" . $dataVolSimulacro['idVoluntario'] . "' and idSimulacro = '".$dataVolSimulacro['idSimulacro']."'", Adapter::QUERY_MODE_EXECUTE);
	    
	    $res = $consulta->toArray();
	    
	    return $res;
	}
	
	public function numeroVoluntario($dataVolSimulacro){
	    
	    $consulta=$this->dbAdapter->query("select COUNT(*) as totalVoluntario FROM voluntario_simulacro_grupo where idSimulacro = '" . $dataVolSimulacro."'" ,Adapter::QUERY_MODE_EXECUTE);
	    
	    $res=$consulta->toArray();
	    
	    return $res;
// 	    print_r($res);
// 	    exit;

	}
	

	
	public function buscarDetalleVoluntario($decodePostData){
	    $sql = new Sql($this->dbAdapter);
	    	    $select = $sql->select();
	    	    $select
	    	    ->from(array('t1'=>'voluntario_simulacro_grupo'), array())
	    	    ->join(array('t2'=>'simulacrogrupo'), 't1.idSimulacro = t2.id', array('ubicacion','fecha','hora'))
	    	    ->join(array('t3'=>'voluntario'), 't3.id=t1.idVoluntario' , array('alias'))
	    	    ->Where(array('t1.idSimulacro'=>$decodePostData['idSimulacro']));
	            	        
	            $selectString = $sql->getSqlStringForSqlObject($select);
	            	        //print_r($selectString); exit;
	            $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	            $result = $execute->toArray();
	            	        //echo "<pre>"; print_r($result); exit;
	            
	            // 	        print_r($result);
	            // 	        exit;
	            
	            	        return $result;
	}
	
	
	public function listaVoluntario($dataVolSimulacro){
	   
	    
	    $consulta=$this->dbAdapter->query("select idVoluntario FROM voluntario_simulacro_grupo where idSimulacro = '" . $dataVolSimulacro["idSimulacro"]."'" ,Adapter::QUERY_MODE_EXECUTE);
	    $res=$consulta->toArray();
	    
	    return $res;
	    // 	    print_r($res);
	    // 	    exit;
	    
	}
	
	public function eliminaVoluntario($dataVolSimulacro){
	    
	    $flag = false;
	    $respuesta = array();
	    try {
	        
	        $sql = new Sql($this->dbAdapter);
	        $delete = $sql->delete('voluntario_simulacro_grupo');
	        $delete->where(array('idSimulacro' => $dataVolSimulacro["idSimulacro"]));
	        
	        $selectString = $sql->getSqlStringForSqlObject($delete);
	        $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
	        
	        
	       // $consulta=$this->dbAdapter->query("DELETE FROM voluntario_simulacro_grupo where idSimulacro = '" . $dataPartSismo["idSimulacro"]."'" ,Adapter::QUERY_MODE_EXECUTE);
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
	
	
	
	
	
	
	public function eliminarVolDeSimulacro($dataVolSimulacro){
	    $flag = false;
	    $respuesta = array();
	    try {
	        $consulta=$this->dbAdapter->query("DELETE FROM voluntario_simulacro_grupo where idVoluntario = '" . $dataVolSimulacro["idVoluntario"]."' and idSimulacro = '".$dataVolSimulacro['idSimulacro']."'" ,Adapter::QUERY_MODE_EXECUTE);
	        $flag = true;
	    }
	    catch (\PDOException $e) {
	        echo "First Message " . $e->getMessage() . "<br/>";
	        $flag = false;
	    }catch (\Exception $e) {
	        echo "Second Message: " . $e->getMessage() . "<br/>";
	    }
	    $respuesta['status'] = $flag;
	    
	    return $respuesta;
	    // 	    print_r($res);
	    // 	    exit;
	    
	}
	
	public function buscarSimulacro($id){
	    
	    $consulta=$this->dbAdapter->query("select idSimulacro FROM voluntario_simulacro_grupo where idVoluntario = '" . $id."'" ,Adapter::QUERY_MODE_EXECUTE);
	    
	    $res=$consulta->toArray();
	    
	    return $res;
	    // 	    print_r($res);
	    // 	    exit;
	    
	}
	
	
	
	
	
	
}
?>