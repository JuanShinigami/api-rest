<?php

namespace Application\Service;

use Application\Model\MensajeModel;

class MensajeService
{
	private $mensajeModel;
	
	private $validarToken;
	
	private $voluntCreadorService;
	
	private function getMensajeModel()
	{
		return $this->mensajeModel = new MensajeModel();
	}

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
		$mensaje = $this->getMensajeModel()->getAll();

		return $mensaje;
	}


	public function addMensaje($dataMensaje)
	{
	    $token=$this->getValidarToken()->validaToken($dataMensaje);
	    
	    $res=array();
	    if ($token['status']) {
	  	    $mensaje = $this->getMensajeModel()->addMensaje($dataMensaje);
	  	  
	  	    $res['mensaje'] = $mensaje;
	  	    $res['StatusToken'] = $token;
	  	}else {
	  	    $res = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false', "token" =>$token);
	  	}
	  	
	  	return $res;
	}
	
	public function buscarMensaje($id)
	{
	    $token=$this->getValidarToken()->validaToken($id);
	        
	    if ($token['status']) {
	            
	        $mensaje = array("mensaje"=>$this->getMensajeModel()->buscarMensaje($id['idSimulacrogrupo']), "StatusToken"=>$token);
	    }else {
	        $mensaje = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false',"token" =>$token);
	    }
	    
	    return $mensaje;
	}
}
?>