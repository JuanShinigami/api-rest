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
	
	private $validarToken;
	
	private function getValidarToken()
	{
	    return $this->validarToken = new ValidarTokenService();
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
	   $resArray= array();
	   
	   if($this->getValidarToken()->validaToken($dataSimulacroGrupo)){
		    
		  $simulacroGrupo = $this->getSimulacroGrupoModel()->addSimulacroGrupo($dataSimulacroGrupo); 
		  $idSimulacro = $this->getSimulacroGrupoModel()->idSimulacro($dataSimulacroGrupo); 
		  $dataVolSimulacro = array();
		  $dataVolSimulacro['idVoluntario'] = $dataSimulacroGrupo['idVoluntarioCreador'];
		  $dataVolSimulacro['idSimulacro'] = $idSimulacro;
		  $dataVolSimulacro['tipoSimulacro'] = $dataSimulacroGrupo['tipoSimulacro'];
		  $voluntarioSimulacroId = $this->getVoluntarioSimulacroModel()->addVoluntarioSimulacro($dataVolSimulacro);
		  
// 		  $resArray['agrego']= $simulacroGrupo;
		  $resArray['voluntarioSimulacro']= $voluntarioSimulacroId;
		  $resArray['idSimulacrum'] = $idSimulacro;
		
		}else {
		    $resArray['Mensaje'] = "Acceso denegado";
		    $resArray['flag']='false';
		}
		
		return $resArray;
	}
	
	
	public function countVoluntario($decodePostData)
	{
	    $countVoluntary = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
	    return $countVoluntary;
	    
	}
	public function updateEstatus($decodePostData) {
	    
	    if($this->getValidarToken()->validaToken($decodePostData)){
	        $detalles = $this->getSimulacroGrupoModel()->updateEstatusSimulacro($decodePostData);
	    }else {
	        $detalles = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
	    }
	    return $detalles;
	    
	}

	public function buscarDetalles($decodePostData) {
	    
	    if($this->getValidarToken()->validaToken($decodePostData)){
	        $detalles = $this->getSimulacroGrupoModel()->buscarDetalles($decodePostData);
	    }else {
	        $detalles = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
	    }
	    return $detalles;
	}
	
}
?>