<?php

namespace Application\Service;

use Application\Model\SimulacroGrupoModel;
use Application\Model\VoluntarioSimulacroModel;

class SimulacroGrupoService
{
	private $simulacroGrupoModel;
	private $voluntCreadorService;
	private $voluntarioSimulacroModel;
	
	private function getSimulacroGrupoModel()
	{
	    return $this->simulacroGrupoModel = new SimulacroGrupoModel();
	}

	private function getVoluntarioSimulacroModel()
	{
	    return $this->voluntarioSimulacroModel = new VoluntarioSimulacroModel();
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
	   $resArray= array();
		if($token == true){
		  $simulacroGrupo = $this->getSimulacroGrupoModel()->addSimulacroGrupo($dataSimulacroGrupo); 
		  $idSimulacro = $this->getSimulacroGrupoModel()->idSimulacro($dataSimulacroGrupo); 
		  $dataVolSimulacro = array();
		  $dataVolSimulacro['idVoluntario'] = $dataSimulacroGrupo['idVoluntarioCreador'];
		  $dataVolSimulacro['idSimulacro'] = $idSimulacro;
		  $dataVolSimulacro['tipoSimulacro'] = $dataSimulacroGrupo['tipoSimulacro'];
		  $voluntarioSimulacroId = $this->getVoluntarioSimulacroModel()->addVoluntarioSimulacro($dataVolSimulacro);
		  
// 		  $resArray['agrego']= $simulacroGrupo;
		  $resArray['id']= $idSimulacro;
		}else {
		    $resArray['token'] = "token incorrecto";
		}
		
		
		return $resArray;

	}
	
	
	public function countVoluntario($decodePostData)
	{
	    $countVoluntary = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
	    return $countVoluntary;
	    
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