<?php
namespace Application\Service;

use Application\Model\VoluntarioSimulacroModel;
use Application\Model\SimulacroGrupoModel;
use Application\Model\MensajeModel;

class VoluntarioSimulacroService
{

    private $voluntarioSimulacroModel;

    private $simulacroGrupoModel;

    private $mensajeModel;
    private $voluntCreadorService;
    
    private function getVoluntarioSimulacroModel()
    {
        return $this->voluntarioSimulacroModel = new VoluntarioSimulacroModel();
    }

    private function getSimulacroGrupoModel()
    {
        return $this->simulacroGrupoModel = new SimulacroGrupoModel();
    }

    private function getMensajeModel()
    {
        return $this->mensajeModel = new MensajeModel();
    }

    
    
    public function getVoluntCreadorService(){
        return $this->voluntCreadorService = new VoluntarioCreadorService();
    }
    
    /**
     * Obtenermos todos los Voluntarios
     */
    public function getAll()
    {
        $voluntariosSimulacro = $this->getVoluntarioSimulacroModel()->getAll();
        
        return $voluntariosSimulacro;
    }

    public function addVoluntarioSimulacro($dataVolSimulacro)
    {
        $voluntariosSimulacro = $this->getVoluntarioSimulacroModel()->existe($dataVolSimulacro);
       
        
        if (empty($voluntariosSimulacro)) {
            $voluntariosSimulacro = $this->getVoluntarioSimulacroModel()->addVoluntarioSimulacro($dataVolSimulacro);
            $buscaTotalVoluntario = $this->getVoluntarioSimulacroModel()->numeroVoluntario($dataVolSimulacro["idSimulacro"]);
            $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $dataVolSimulacro["idSimulacro"]);
        } else {
            $voluntariosSimulacro = "Ya esta registrado en este simulacro ";
        }
        return $voluntariosSimulacro;
    }

    public function updateVoluntario($decodePostData)
    {
        $updateVoluntario = $this->getVoluntarioSimulacroModel()->updateVoluntario($decodePostData);
        
        return $updateVoluntario;
    }

    public function buscarDetalleVoluntario($decodePostData)
    {
        $token = $this->getVoluntCreadorService()->validaToken($decodePostData);
        if($token == true){
        $detallesVoluntario = $this->getVoluntarioSimulacroModel()->buscarDetalleVoluntario($decodePostData);
        }else {
            $detallesVoluntario = "token incorrecto";
        }
        return $detallesVoluntario;
    }

    public function listaVoluntario($decodePostData)
    {
        $token = $this->getVoluntCreadorService()->validaToken($decodePostData);
        if($token == true){
            
       
        $arrayRespuesta = array();
        
        $listaVoluntario = $this->getVoluntarioSimulacroModel()->listaVoluntario($decodePostData);
        
        $eliminaVoluntario = $this->getVoluntarioSimulacroModel()->eliminaVoluntario($decodePostData);
        $eliminaMensaje = $this->getMensajeModel()->eliminaMensaje($decodePostData['idSimulacro']);
        
        $eliminaSimulacro = $this->getSimulacroGrupoModel()-> eliminarSimulacro($decodePostData);
        
        $arrayRespuesta['lista'] = $listaVoluntario;
        $arrayRespuesta['simulacro'] = $eliminaSimulacro;
         }else {
             $arrayRespuesta['token'] = "token incorrecto";
             
         }
        return $arrayRespuesta;
    }

    public function eliminarVolDeSimulacro($decodePostData)
    {
        // print_r($decodePostData['id']);
        // $idSismo = $this->getVoluntarioSismoModel()->buscarSismo($decodePostData['id']);
        // $eliminarVoluntario = $this->getVoluntarioSismoModel()->eliminarPartDeSismo($decodePostData);
        // $buscaTotalVoluntario = $this->getVoluntarioSismoModel()->numeroVoluntarios($idSismo[0]['idSismo']);
        // $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $idSismo[0]['idSismo']);
        
        // return $eliminarVoluntario;
        $arrayR = array();
        // print_r($decodePostData['id']);
        // --$idSismo = $this->getVoluntarioSismoModel()->buscarSismo($decodePostData['id']);
        
        $eliminarVoluntario = $this->getVoluntarioSimulacroModel()->eliminarVolDeSimulacro($decodePostData);
        $buscaTotalVoluntario = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
        $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $decodePostData['idSimulacro']);
        $arrayR['respuesta'] = $eliminarVoluntario;
        $arrayR['totalVoluntario'] = ($buscaTotalVoluntario[0]['totalVoluntario']) + 1;
        return $arrayR;
    }
}
?>