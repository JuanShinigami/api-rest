<?php
namespace Application\Service;

use Application\Model\VoluntarioSimulacroIndividualModel;


class VoluntarioSimulacroIndividualService
{
    private $voluntarioSimulacroIndividualModel;
    
    private function getVoluntarioSimulacroIndividualModel()
    {
        return $this->voluntarioSimulacroIndividualModel = new VoluntarioSimulacroIndividualModel();
    }
    
    public function addVoluntarioSimulacro($dataVolSimulacro)
    {
     
        $resArray = array();
        
        $voluntariosSimulacro = $this->getVoluntarioSimulacroIndividualModel()->addVoluntarioSimulacroIndividual($dataVolSimulacro);
        
        $resArray['voluntarioSimulacro'] = $voluntariosSimulacro;
        //$resArray['status'] = "true";
        
        
        return $resArray;
    }
    
    
    public function eliminarVolDeSimulacroIndividual($decodePostData)
    {
    
//         $arrayR = array();
       
        $eliminarVoluntario = $this->getVoluntarioSimulacroIndividualModel()->eliminarVolDeSimulacroIndividual($decodePostData);
       
        return $eliminarVoluntario;
    }
    
}