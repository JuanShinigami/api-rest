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
	  	if($this->getValidarToken()->validaToken($dataMensaje)){
	  	    $mensaje = $this->getMensajeModel()->addMensaje($dataMensaje);
	  	}else {
	  	    $mensaje = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
	  	}
	  	
	  	return $mensaje;
	}
	
	public function buscarMensaje($id)
	{
	    if($this->getValidarToken()->validaToken($id)){
	        $mensaje = $this->getMensajeModel()->buscarMensaje($id['idSimulacrogrupo']);
	    }else {
	        $mensaje = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
	    }
	    
	    return $mensaje;
	}
}
?>