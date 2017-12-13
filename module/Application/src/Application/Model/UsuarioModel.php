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
        $this->dbAdapter = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table = 'usuarios';
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
            'folio',
            'nombre',
            'telefono',
            'correo'
        ))->from(array(
            'u' => $this->table
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
        // $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select id , folio , nombre, correo FROM usuarios where folio = '" . $folioNuevo . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        // echo "res ";
        // print_r($res);
        
        return $res;
    }

    public function maxFolio($folioNuevo)
    {
        
        // $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select max(folio) as maxFolio FROM usuarios where folio like '" . $folioNuevo . "%'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        return $res;
    }

    public function existeCorreo($dataUser)
    {
        // $consulta=$this->dbAdapter->query("select id , folio FROM usuarios where nombre = '" . $dataUser['nombre']."' and correo = '".$dataUser['correo']. "'" ,Adapter::QUERY_MODE_EXECUTE);
        $consulta = $this->dbAdapter->query("select id , folio, correo FROM usuarios where correo = '" . $dataUser['correo'] . "'", Adapter::QUERY_MODE_EXECUTE);
        
        $res = $consulta->toArray();
        // echo "existe correo";
        // print_r($res);
        
        return $res;
    }

    public function addUsuarios($dataUser, $folioNuevo)
    {
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $insertar = $sql->insert('usuarios');
            
            $array = array(
                
                'folio' => $folioNuevo,
                'nombre' => $dataUser["nombre"],
                'telefono' => $dataUser["telefono"],
                'correo' => $dataUser["correo"]
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
        $respuesta['folio'] = $folioNuevo;
        
        return $respuesta;
    }

    public function updateUsuarios($usuario, $folioNuevo)
    {
        
        // print_r($usuario[0]['id']);
        $flag = false;
        $respuesta = array();
        
        try {
            $sql = new Sql($this->dbAdapter);
            $update = $sql->update();
            $update->table('usuarios');
            
            $array = array(
                
                'folio' => $folioNuevo
            );
            
            $update->set($array);
            $update->where(array(
                'id' => $usuario[0]['id']
            ));
            
            $selectString = $sql->getSqlStringForSqlObject($update);
            $results = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
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
}

?>






