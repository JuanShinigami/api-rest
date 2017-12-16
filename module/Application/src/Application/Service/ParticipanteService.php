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
	    $participante = $this->getParticipanteModel()->existe($dataParticipante);
	    
	   
	    
	    if(empty($participante)){
	        $participante = $this->getParticipanteModel()->addParticipante($dataParticipante);
	    }else {
	        $participante="Usted ya esta registrado con el alias: ".$participante[0]['alias'];
	    }
	    return $participante;
	}

}
?>