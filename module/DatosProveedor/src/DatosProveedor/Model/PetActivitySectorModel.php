<?php
namespace DatosProveedor\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class PetActivitySectorModel extends TableGateway
{
    private $dbAdapter;
    
    public function __construct()
    {
        $this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
        $this->table      = 'pet_activity_sector';
        $this->featureSet = new Feature\FeatureSet();
        $this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
        $this->initialize();
    }
    
    /* Todas los datos*/
    public function fetchAll()
    {
        $sql    = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select
        ->from(array('a_s' => $this->table))
        ->order('a_s.sector_order ASC');
        
        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result       = $execute->toArray();
        return $result;
    }
    
    public function addSector($sector){
        $insert=$this->insert(array(
            "sector"    => $sector,
            "registration_date" => date("Y-m-d H:i:s"),
            "registration_update" => date("Y-m-d H:i:s"),
        ));
        return $insert;
    }
    
    
    /* Borrar dato*/
    public function deleteById($id)
    {
        return $this->delete(array("id"=>$id));
    }
    
    public function getSector($id){
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array('sector'))
        ->from($this->table)
        ->where(array('id' => $id));
        
        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result=$execute->toArray();
        return $result[0];
    }
    
    
    public function updateSector($id,$sector){
        $update=$this->update(array(
            "sector"    => $sector
        ),
            array("id"=>$id));
        return $update;
    }
    
}