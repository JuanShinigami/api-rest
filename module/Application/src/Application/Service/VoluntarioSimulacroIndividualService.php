<?php
namespace Application\Service;

use Application\Model\VoluntarioSimulacroIndividualModel;


class VoluntarioSimulacroIndividualService
{
    private $voluntarioSimulacroIndividualModel;
    private $validarToken;
    
    private function getVoluntarioSimulacroIndividualModel()
    {
        return $this->voluntarioSimulacroIndividualModel = new VoluntarioSimulacroIndividualModel();
    }
    
    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
    }

    public function getAllSimulacrumByCreator($data)
    {
        $resultSelect = $this->getVoluntarioSimulacroIndividualModel()->getAllSimulacrumByCreator($data['idVoluntario']);

        return $resultSelect;
    }
    
    public function addVoluntarioSimulacro($dataVolSimulacro)
    {
      
        $resArray = array();
        
        if ($this->getValidarToken()->validaToken($dataVolSimulacro)) {
        
        $voluntariosSimulacro = $this->getVoluntarioSimulacroIndividualModel()->addVoluntarioSimulacroIndividual($dataVolSimulacro);
        
        $resArray['voluntarioSimulacro'] = $voluntariosSimulacro;
        }else{
            $resArray["Mensaje :" ] ="Acceso denegado";
            $resArray["flag :"] ='false';
        }
        //$resArray['status'] = "true";
        
        
        return $resArray;
    }
    
    
    public function eliminarVolDeSimulacroIndividual($decodePostData)
    {
    
        $arrayR = array();
        if ($this->getValidarToken()->validaToken($decodePostData)) {
        $eliminarVoluntario = $this->getVoluntarioSimulacroIndividualModel()->eliminarVolDeSimulacroIndividual($decodePostData);
        $arrayR=$eliminarVoluntario;
        }else{
            $arrayR["Mensaje :" ] ="Acceso denegado";
            $arrayR["flag :"] ='false';
        }
        return $arrayR;
    }
    
}