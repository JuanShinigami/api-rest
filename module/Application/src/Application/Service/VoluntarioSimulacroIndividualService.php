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
        $resArray = array();
        $resultSelect = null;
        $flag = false;
        
        $token=$this->getValidarToken()->validaToken($data);
            
        if ($token['status']) {
            $resultSelect = $this->getVoluntarioSimulacroIndividualModel()->getAllSimulacrumByCreator($data['idVoluntaryCreator']);
            $flag = true;
        } else{
            $flag = false;
        }       
        $resArray['status'] = $flag;
        $resArray['list'] = $resultSelect;
        $resArray['token'] = $token;
        

        return $resArray;
    }
    
    public function addVoluntarioSimulacro($dataVolSimulacro)
    {
      
        $resArray = array();
        
        $token=$this->getValidarToken()->validaToken($dataVolSimulacro);
        
        
        if ($token['status']) {
        $voluntariosSimulacro = $this->getVoluntarioSimulacroIndividualModel()->addVoluntarioSimulacroIndividual($dataVolSimulacro);
        
        $resArray['voluntarioSimulacro'] = $voluntariosSimulacro;
        }else{
            $resArray["Mensaje :" ] ="Acceso denegado";
            $resArray["flag :"] ='false';
            $resArray["flag :"] =$token;
        }
        //$resArray['status'] = "true";
        
        
        return $resArray;
    }
    
    
    public function eliminarVolDeSimulacroIndividual($decodePostData)
    {
    
        $arrayR = array();
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
        $eliminarVoluntario = $this->getVoluntarioSimulacroIndividualModel()->eliminarVolDeSimulacroIndividual($decodePostData);
        $arrayR=$eliminarVoluntario;
        }else{
            $arrayR["Mensaje :" ] ="Acceso denegado";
            $arrayR["flag :"] ='false';
            $arrayR["flag :"] =$token;
        }
        return $arrayR;
    }
    
}