<?php

namespace Application\Service;

use Application\Model\ParticipanteSismoModel;

class ParticipanteSismoService
{
	private $participanteSismoModel;
	
	private function getParticipanteSismoModel()
	{
		return $this->participanteSismoModel = new ParticipanteSismoModel();
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
		print_r($participantesSismo);
		exit;

		return $participantesSismo;

	}

	public function buscarDetalleParticipante($id){
	    
	    $detallesParticipante = $this->getParticipanteSismoModel()->buscarDetalleParticipante($id);
	    
	    return $detallesParticipante;
	}
}
?>