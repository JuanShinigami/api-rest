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
    
    private $validarToken;
    
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

    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
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

    public function getAllByClient($id){
        //$response = array();
        $arrayListSimulacrumCreate = array();
        $arrayListSimulacrumJoin = array();
        $listSimulacrumCreate = $this->getVoluntarioSimulacroModel()->getAllByClientCreate($id);
        $listSimulacrumJoin = $this->getVoluntarioSimulacroModel()->getAllByClientJoin($id);



        foreach ($listSimulacrumCreate as &$simulacrum) {
            //echo $simulacrum['id'];
            //$data = array();
            //$data['id'] = $simulacrum['id'];

            $simulacrumDetails = $this->getSimulacroGrupoModel()->searchSimulacrum($simulacrum);
            if($simulacrumDetails[0]['estatus'] == "Creada"){
                $simulacrumDetails[0]['status'] = true;
            }else{
                $simulacrumDetails[0]['status'] = false;
            }
            $result = array_merge($simulacrumDetails[0], $simulacrum);
            //$result = $simulacrum + $simulacrumDetails;
            //print_r($simulacrumDetails[0]);
            //exit;
            array_push($arrayListSimulacrumCreate, $result);

        }

        foreach ($listSimulacrumJoin as &$simulacrum) {
            //echo $simulacrum['id'];
            //$data = array();
            //$data['id'] = $simulacrum['id'];
            

            $simulacrumDetails = $this->getSimulacroGrupoModel()->searchSimulacrum($simulacrum);
            if($simulacrum['tiempo_inicio'] == ""){
                $simulacrumDetails[0]['status'] = true;
            }else{
                $simulacrumDetails[0]['status'] = false;
            }
            $result = array_merge($simulacrumDetails[0], $simulacrum);

            //$result = $simulacrum[''] + $simulacrumDetails[0];
            //$result['simulacrum'] = $simulacrum;
            //$result['detail'] = $simulacrumDetails[0];
            array_push($arrayListSimulacrumJoin, $result);

        }
        //print_r($arrayLisSimulacrumCreate);
        //echo count($arrayListSimulacrumJoin);

        //$response['listSimulacrumCreate'] = $listSimulacrumCreate;
        //$response['listSimulacrumJoin'] = $listSimulacrumJoin;
        return array(
                "listSimulacrumCreate" => $arrayListSimulacrumCreate,
                "listSimulacrumJoin" => $arrayListSimulacrumJoin,
            );
    }

    public function addVoluntarioSimulacro($dataVolSimulacro)
    {
        $token=$this->getValidarToken()->validaToken($dataVolSimulacro);
        if ($token['status']) {
            $voluntariosSimulacro = $this->getVoluntarioSimulacroModel()->existe($dataVolSimulacro);
//             print_r($voluntariosSimulacro);
            if (empty($voluntariosSimulacro)) {
                
                
                $voluntariosSimulacro =  array("voluntarioSimulacro"=>$this->getVoluntarioSimulacroModel()->addVoluntarioSimulacro($dataVolSimulacro),  "StatusToken" =>$token);
                $buscaTotalVoluntario = $this->getVoluntarioSimulacroModel()->numeroVoluntario($dataVolSimulacro["idSimulacro"]);
                $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $dataVolSimulacro["idSimulacro"]);
            
            } else {
                $voluntariosSimulacro =  array("Mensaje"=>"Ya esta registrado en este simulacro ", "StatusToken" =>$token);
            }
        } else {
            $voluntariosSimulacro = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        return $voluntariosSimulacro;
    }

    public function updateVoluntario($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
            $updateVoluntario =array("updateVoluntario"=> $this->getVoluntarioSimulacroModel()->updateVoluntario($decodePostData),"StatusToken" =>$token);
        } else {
            $updateVoluntario = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        
        return $updateVoluntario;
    }
    
    
    public function listaVoluntarioUnidos($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
            $updateVoluntario = array("listaVoluntarioUnidos"=> $this->getVoluntarioSimulacroModel()->listaVoluntarioUnidos($decodePostData),"StatusToken" =>$token);
        } else {
            $updateVoluntario = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        
        return $updateVoluntario;
    }

    public function buscarDetalleVoluntario($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
            $detallesVoluntario = array("detalleVoluntario"=> $this->getVoluntarioSimulacroModel()->buscarDetalleVoluntario($decodePostData),"StatusToken" =>$token);
        } else {
            $detallesVoluntario = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        return $detallesVoluntario;
    }
    
    
    public function buscarDetalleVoluntarioPorVoluntarioCreador($decodePostData)
    {
        
//         print_r($decodePostData);exit;
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
            $detallesVoluntario = array("detalleVoluntarioPorCreador"=>$this->getVoluntarioSimulacroModel()->buscarDetalleVoluntarioPorVoluntarioCreador($decodePostData),"StatusToken" =>$token);
        } else {
            $detallesVoluntario = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        return $detallesVoluntario;
    }

    public function searchDateAndHourSimulacrum($decodePostData)
    {
        
//         print_r($decodePostData);exit;
        $token=$this->getValidarToken()->validaToken($decodePostData);
        
        if ($token['status']) {
            $detallesVoluntario = array("fechaHoraSimulacro"=> $this->getVoluntarioSimulacroModel()->searchDateAndHourSimulacrum($decodePostData['idSimulacrumGroup']),"StatusToken" =>$token);
        } else {
            $detallesVoluntario = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        return $detallesVoluntario;
    }

    public function listaVoluntario($decodePostData)
    {
        $arrayRespuesta = array();
        $token=$this->getValidarToken()->validaToken($decodePostData);
        if ($token['status']) {
            $listaVoluntario = $this->getVoluntarioSimulacroModel()->listaVoluntario($decodePostData);
            
            $eliminaVoluntario = $this->getVoluntarioSimulacroModel()->eliminaVoluntario($decodePostData);
            $eliminaMensaje = $this->getMensajeModel()->eliminaMensaje($decodePostData['idSimulacro']);
            
            $eliminaSimulacro = $this->getSimulacroGrupoModel()->eliminarSimulacro($decodePostData);
            
            $arrayRespuesta['lista'] = $listaVoluntario;
            $arrayRespuesta['simulacro'] = $eliminaSimulacro;
            $arrayRespuesta['StatusToken'] = $token;
        } else {
            $arrayRespuesta['Mensaje'] = "Acceso denegado";
            $arrayRespuesta['flag'] = "false";
            $arrayRespuesta['StatusToken'] = $token;
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
        
        $token=$this->getValidarToken()->validaToken($decodePostData);
        
        if ($token['status']) {
            // print_r($decodePostData['id']);
            // --$idSismo = $this->getVoluntarioSismoModel()->buscarSismo($decodePostData['id']);
            
            $eliminarVoluntario = $this->getVoluntarioSimulacroModel()->eliminarVolDeSimulacro($decodePostData);
            $buscaTotalVoluntario = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
            $actualizaParticipates = $this->getSimulacroGrupoModel()->updateNumeroVoluntario($buscaTotalVoluntario, $decodePostData['idSimulacro']);
            $arrayR['respuesta'] = $eliminarVoluntario;
            $arrayR['totalVoluntario'] = ($buscaTotalVoluntario[0]['totalVoluntario']) + 1;
            $arrayR['StatusToken'] =$token;
        } else {
            $arrayR['Mensaje'] = "Acceso denegado";
            $arrayR['flag'] = "false";
            $arrayR['StatusToken'] = $token;
        }
        return $arrayR;
    }
}
?>