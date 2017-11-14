<?php

namespace Application\Service;

use Application\Model\ParticipanteModel;

class ParticipanteService
{
	private $participanteModel;
	
	private function getParticipanteModel()
	{
		return $this->participanteModel = new ParticipanteModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$participantes = $this->getParticipanteModel()->getAll();

		return $participantes;
	}
	
	public function addParticipante($dataParticipante)
	{
	    $participante = $this->getParticipanteModel()->addParticipante($dataParticipante);
	    print_r($participante);
	    exit;
	    
	    return $participante;
	}

}
?>