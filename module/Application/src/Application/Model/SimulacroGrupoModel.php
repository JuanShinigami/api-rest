<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class SimulacroGrupoModel extends TableGateway
{

    private $dbAdapter;

    public function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'simulacrogrupo';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
    }

    /**
     * OBTEMOS TODOS los sismos
     */
    public function getAll()
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'ubicacion',
            'fecha',
            'hora',
            'voluntario',
            'idVoluntarioCreador'
        ))->from(array(
            's' => $this->table
        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        // print_r($selectString); exit;
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        // echo "<pre>"; print_r($result); exit;
        
        return $result;
    }

    public function addSimulacroGrupo($dataSimulacroGrupo)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            
            $sql = new Sql($this->dbAdapter);
            
            $insertar = $sql->insert('simulacrogrupo');
            
            $array = array(
                
                'ubicacion' => $dataSimulacroGrupo["ubicacion"],
                'latitud' => $dataSimulacroGrupo["latitud"],
                'longitud' => $dataSimulacroGrupo["longitud"],
                'fecha' => $dataSimulacroGrupo["fecha"],
                'hora' => $dataSimulacroGrupo["hora"],
                'voluntario' => 1,
                'idVoluntarioCreador' => $dataSimulacroGrupo["idVoluntarioCreador"]
            );
            // print_r($array);
            // exit;
            $insertar->values($array);
            
            $selectString = $sql->getSqlStringForSqlObject($insertar);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
            $flag = true;
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        
        // print_r($results);
        
        return $respuesta;
    }

    public function updateNumeroVoluntario($total, $idSimulacro)
    {
        $flag = false;
        $respuesta = array();
        
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table('simulacrogrupo');
            
            $array = array(
                
                'voluntario' => $total[0]["totalVoluntario"] + 1
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $idSimulacro
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

    public function buscarDetalles($decodePostData)
    {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        
        $select->from(array(
            't1' => 'simulacrogrupo'
        ), array())->where(array(
            'idVoluntarioCreador' => $decodePostData['id']
        ));
        
        // print_r($result);
        // exit;
        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        
        // echo "<pre>"; print_r($result); exit;
        
        // print_r($result);
        // exit;
        
        return $result;
    }
    
    public function eliminarSimulacro($dataPartSimulacro)
    {
        $flag = false;
        $respuesta = array();
        
        
        try {
            //$consulta=$this->dbAdapter->query("DELETE FROM simulacrogrupo where idSismo = '" . $dataPartSismo["idSismo"]."'" ,Adapter::QUERY_MODE_EXECUTE);
            $sql = new Sql($this->dbAdapter);
            $delete = $sql->delete('simulacrogrupo');
            $delete->where(array('id' => $dataPartSimulacro["idSimulacro"]));
            
            $selectString = $sql->getSqlStringForSqlObject($delete);
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
    
    
}
?>