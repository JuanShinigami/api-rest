<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class VoluntarioSimulacroIndividualModel extends TableGateway
{
    private $dbAdapter;
    
    public function __construct()
    {
        $this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table      = 'voluntario_simulacro_individual';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
    }
    
    public function getAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select
        ->columns(array('id', 'idVoluntario', 'tiempo_inicio', 'tiempo_estoy_listo'))
        ->from(array('s' => $this->table));
        $selectString = $sql->getSqlStringForSqlObject($select);
        //print_r($selectString); exit;
        $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result       = $execute->toArray();
        //echo "<pre>"; print_r($result); exit;
        
        return $result;
    }
    
    public function addVoluntarioSimulacroIndividual($dataVolSimulacro){
        
        // 	    print_r($dataVolSimulacro);
        
        // 	    exit;
        
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $insertar = $sql->insert('voluntario_simulacro_individual');
            $array=array(
                
                'idVoluntario'=>$dataVolSimulacro['idVoluntario'],
                'tiempo_inicio'=>$dataVolSimulacro['tiempo_inicio'],
                'tiempo_estoy_listo'=>$dataVolSimulacro['tiempo_estoy_listo'],
                //'mensajeParticipante'=>$dataPartSismo["mensajeParticipante"]
            );
            
            $insertar->values($array);
            $selectString = $sql->getSqlStringForSqlObject($insertar);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            
            // echo "existe correo";
            //          print_r($);
            //          exit;
            
            //return $res[0]['id'];
            //echo $res[0]['id'];
            //print_r($results);
            //exit;
            $flag = true;
            
            
        }catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        }catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        
        return $respuesta;
        
    }
    
    public function eliminarVolDeSimulacroIndividual($dataVolSimulacro){
        $flag = false;
        $respuesta = array();
        try {
            $consulta=$this->dbAdapter->query("DELETE FROM voluntario_simulacro_individual where idVoluntario = '" . $dataVolSimulacro["idVoluntario"]."'" ,Adapter::QUERY_MODE_EXECUTE);
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
    
    
}