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
		$buscaTotalParticipante=$this->getParticipanteSismoModel()->numeroParticipantes($dataPartSismo);
		$actualizaParticipates=$this->getSismoGrupoModel()->updateNumeroParticipante($buscaTotalParticipante, $dataPartSismo);
		return $participantesSismo;

	}
	
	

	public function buscarDetalleParticipante($decodePostData){
	    
	    $detallesParticipante = $this->getParticipanteSismoModel()->buscarDetalleParticipante($decodePostData);
	    
	    return $detallesParticipante;
	}
}
?>