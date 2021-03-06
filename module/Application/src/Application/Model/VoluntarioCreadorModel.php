<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class VoluntarioCreadorModel extends TableGateway
{

    private $dbAdapter;

    public function __construct()
    {
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'voluntarioCreador';
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
        $select->columns(array(
            'id',
            'contrasena',
            'nombre',
            'telefono',
            'correo',
            'idPerfil'
        ))->from(array(
            'v' => $this->table
        ));
        $selectString = $sql->getSqlStringForSqlObject($select);
        // print_r($selectString); exit;
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        // echo "<pre>"; print_r($result); exit;
        
        return $result;
    }

    public function existe($folioNuevo)
    {
        
        // print_r($folioNuevo);
        // $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select id , nombre, correo FROM voluntarioCreador where correo = '" . $folioNuevo . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        // echo "res ";
        // print_r($res);
        
        return $res;
    }

    public function maxFolio($folioNuevo)
    {
        
        // $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select max(folio) as maxFolio FROM voluntarioCreador where folio like '" . $folioNuevo . "%'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        return $res;
    }

    public function existeCorreo($dataUser)
    {
        
        // $consulta=$this->dbAdapter->query("select id , folio FROM voluntarioCreador where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select id , correo FROM voluntarioCreador where correo = '" . $dataUser['correo'] . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        // echo "existe correo";
        // print_r($res);
        
        return $res;
    }

    public function addVolCreador($dataVolCreador, $securePass)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $insertar = $sql->insert('voluntarioCreador');
            
            $array = array(
                
                'contrasena' => $securePass,
                'nombre' => $dataVolCreador["nombre"],
                'telefono' => $dataVolCreador["telefono"],
                'correo' => $dataVolCreador["correo"],
                'idPerfil' => $dataVolCreador["idPerfil"]
            );
            
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
//         $respuesta['folio'] = $folioNuevo;
        
//         print_r($respuesta);exit;
        
        return $respuesta;
    }

    public function updateVoluntarioCreador($volCreador, $folioNuevo)
    {
        
        // print_r($usuario[0]['id']);
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table('voluntarioCreador');
            
            $array = array(
                
                'folio' => $folioNuevo
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $volCreador[0]['id']
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
        // $respuesta['folio'] = $folioNuevo;
        return $respuesta;
    }

    public function registroVoluntario($folioNuevo,$pass)
    {
//        print_r($folioNuevo);
//        print_r("   -----   >   ");
//        print_r($pass);
//        exit;
        $flag = false;
        $respuesta = array();
        
        try {
                      
            $consulta = $this->dbAdapter->query("select * FROM voluntarioCreador where correo = '" . $folioNuevo['correo'] . "' and contrasena = '" . $pass . "'", Adapter::QUERY_MODE_EXECUTE);
            
            $res = $consulta->toArray();
          
           if(!empty($res)){ 
              
               $flag = true;
               
           } 
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        $respuesta['status'] = $flag;
        $respuesta['datos'] = $res;
        return $respuesta;
    }
}

?>






