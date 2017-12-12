<?php

namespace Application\Service;

use Application\Model\ParticipanteSismoModel;
use Application\Model\SismoGrupoModel;

class ParticipanteSismoService
{
	private $participanteSismoModel;
	private $sismoGrupoModel;
	
	private function getParticipanteSismoModel()
	{
		return $this->participanteSismoModel = new ParticipanteSismoModel();
	}
	
	private function getSismoGrupoModel()
	{
	    return $this->sismoGrupoModel = new SismoGrupoModel();
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
		
		$participantesSismo = $this->getParticipanteSismoModel()->addParticipanteSismo($dataPartSismo);
		$buscaTotalParticipante=$this->getParticipanteSismoModel()->numeroParticipantes($dataPartSismo["idSismo"]);
		$actualizaParticipates=$this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $dataPartSismo["idSismo"]);
		return $participantesSismo;

	}
	
	public function buscarDetalleParticipante($decodePostData){
	    
	    $detallesParticipante = $this->getParticipanteSismoModel()->buscarDetalleParticipante($decodePostData);
	    
	    return $detallesParticipante;
	}
	
	public function listaParticipante($decodePostData){
	    
	    $listaParticipante = $this->getParticipanteSismoModel()->listaParticipantes($decodePostData);
	    $eliminaParticipante = $this->getParticipanteSismoModel()->eliminaParticipantes($decodePostData);
	    $eliminaSismo=$this->getSismoGrupoModel()->eliminarSismo($decodePostData);
	    
	    return $listaParticipante;
	}
	
	
	public function eliminarPartDeSismo($decodePostData){
	    print_r($decodePostData['id']);
	    $idSismo = $this->getParticipanteSismoModel()->buscarSismo($decodePostData['id']);
	    $eliminarParticipante = $this->getParticipanteSismoModel()->eliminarPartDeSismo($decodePostData);
	    $buscaTotalParticipante=$this->getParticipanteSismoModel()->numeroParticipantes($idSismo[0]['idSismo']);
	    $actualizaParticipates=$this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $idSismo[0]['idSismo']);
	    
	    return $eliminarParticipante;
	}
}
?>