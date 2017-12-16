<?php
namespace Application\Service;

use Application\Model\ParticipanteSismoModel;
use Application\Model\SismoGrupoModel;
use Application\Model\MensajeModel;

class ParticipanteSismoService
{

    private $participanteSismoModel;

    private $sismoGrupoModel;
    
    private $mensajeModel;

    private function getParticipanteSismoModel()
    {
        return $this->participanteSismoModel = new ParticipanteSismoModel();
    }

    private function getSismoGrupoModel()
    {
        return $this->sismoGrupoModel = new SismoGrupoModel();
    }

    
    private function getMensajeModel()
    {
        return $this->mensajeModel = new MensajeModel();
    }
    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $participantesSismo = $this->getParticipanteSismoModel()->getAll();
        
        return $participantesSismo;
    }

    public function addParticipanteSismo($dataPartSismo)
    {
        $participantesSismo = $this->getParticipanteSismoModel()->existe($dataPartSismo);
        
        if (empty($participantesSismo)) {
            $participantesSismo = $this->getParticipanteSismoModel()->addParticipanteSismo($dataPartSismo);
            $buscaTotalParticipante=$this->getParticipanteSismoModel()->numeroParticipantes($dataPartSismo["idSismo"]);
            $actualizaParticipates=$this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $dataPartSismo["idSismo"]);
        } else {
            $participantesSismo = "Ya esta registrado en este sismo ";
        }
         return $participantesSismo;
    }

    public function updateParticipante($decodePostData)
    {
        $updateParticipante = $this->getParticipanteSismoModel()->updateParticipante($decodePostData);
        
        return $updateParticipante;
    }
    
    public function buscarDetalleParticipante($decodePostData)
    {
        $detallesParticipante = $this->getParticipanteSismoModel()->buscarDetalleParticipante($decodePostData);
        
        return $detallesParticipante;
    }

    public function listaParticipante($decodePostData)
    {
        $arrayRespuesta = array();
        
        $listaParticipante = $this->getParticipanteSismoModel()->listaParticipantes($decodePostData);
        
        $eliminaParticipante = $this->getParticipanteSismoModel()->eliminaParticipantes($decodePostData);
        $eliminaMensaje = $this->getMensajeModel()->eliminaMensaje($decodePostData['idSismo']);
        
        $eliminaSismo = $this->getSismoGrupoModel()->eliminarSismo($decodePostData);
        
        $arrayRespuesta['lista'] = $listaParticipante;
        $arrayRespuesta['sismo'] = $eliminaSismo;
        
        return $arrayRespuesta;
    }

    public function eliminarPartDeSismo($decodePostData)
    {
//         print_r($decodePostData['id']);
//         $idSismo = $this->getParticipanteSismoModel()->buscarSismo($decodePostData['id']);
//         $eliminarParticipante = $this->getParticipanteSismoModel()->eliminarPartDeSismo($decodePostData);
//         $buscaTotalParticipante = $this->getParticipanteSismoModel()->numeroParticipantes($idSismo[0]['idSismo']);
//         $actualizaParticipates = $this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $idSismo[0]['idSismo']);
        
//         return $eliminarParticipante;

        $arrayR = array();
//         print_r($decodePostData['id']);
//         --$idSismo = $this->getParticipanteSismoModel()->buscarSismo($decodePostData['id']);

        $eliminarParticipante = $this->getParticipanteSismoModel()->eliminarPartDeSismo($decodePostData);
        $buscaTotalParticipante=$this->getParticipanteSismoModel()->numeroParticipantes($decodePostData['idSismo']);
        $actualizaParticipates=$this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $decodePostData['idSismo']);
        $arrayR['respuesta'] = $eliminarParticipante;
        $arrayR['totalParticipante'] = ($buscaTotalParticipante[0]['totalParticipante']) + 1;
        return $arrayR;
    }
}
?>