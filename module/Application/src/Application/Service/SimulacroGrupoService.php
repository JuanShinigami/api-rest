<?php

namespace Application\Service;

use Application\Model\SimulacroGrupoModel;

class SimulacroGrupoService
{
	private $simulacroGrupoModel;
	
	private function getSimulacroGrupoModel()
	{
	    return $this->simulacroGrupoModel = new SimulacroGrupoModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$simulacroGrupo = $this->getSimulacroGrupoModel()->getAll();

		return $simulacroGrupo;
	}


	public function addSimulacro($dataSimulacroGrupo)
	{
		
		$simulacroGrupo = $this->getSimulacroGrupoModel()->addSimulacroGrupo($dataSimulacroGrupo);
		
		return $simulacroGrupo;

	}

	public function buscarDetalles($decodePostData) {
	    
	    $detalles = $this->getSimulacroGrupoModel()->buscarDetalles($decodePostData);
	    
	    return $detalles;
	    
	}
	
}
?>