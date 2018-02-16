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
    
    
}