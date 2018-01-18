<?php

namespace Application\Service;

use Application\Model\SimulacroGrupoModel;

class SimulacroGrupoService
{
	private $simulacroGrupoModel;
	private $voluntCreadorService;
	
	private function getSimulacroGrupoModel()
	{
	    return $this->simulacroGrupoModel = new SimulacroGrupoModel();
	}

	
	
	public function getVoluntCreadorService(){
	    return $this->voluntCreadorService = new VoluntarioCreadorService();
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
	    $token = $this->getVoluntCreadorService()->validaToken($dataSimulacroGrupo);
	   
		if($token == true){
		  $simulacroGrupo = $this->getSimulacroGrupoModel()->addSimulacroGrupo($dataSimulacroGrupo);  
		}else {
		    $simulacroGrupo = "token incorrecto";
		}
		
		
		return $simulacroGrupo;

	}
	
	public function updateEstatus($decodePostData) {
	    
	    $token = $this->getVoluntCreadorService()->validaToken($decodePostData);
	    if($token == true){
	        $detalles = $this->getSimulacroGrupoModel()->updateEstatusSimulacro($decodePostData);
	    }else {
	        $detalles = "token incorrecto";
	    }
	    return $detalles;
	    
	}

	public function buscarDetalles($decodePostData) {
	    
	    $token = $this->getVoluntCreadorService()->validaToken($decodePostData);
	    if($token == true){
	    $detalles = $this->getSimulacroGrupoModel()->buscarDetalles($decodePostData);
	    }else {
	        $detalles = "token incorrecto";
	    }
	    return $detalles;
	    
	}
	
}
?>