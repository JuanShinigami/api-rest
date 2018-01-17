<?php

namespace Application\Service;

use Application\Model\MensajeModel;

class MensajeService
{
	private $mensajeModel;
	
	private function getMensajeModel()
	{
		return $this->mensajeModel = new MensajeModel();
	}

	private $voluntCreadorService;
	
	
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
	    $token = $this->getVoluntCreadorService()->validaToken($dataMensaje);
	    if($token == true){
	         $mensaje = $this->getMensajeModel()->addMensaje($dataMensaje);
	    }else {
	        $mensaje = "token incorrecto";
	    }

	  	return $mensaje;
	}
	
	public function buscarMensaje($id)
	{
	    $token = $this->getVoluntCreadorService()->validaToken($id);
	    
	    if($token == true){
	        $mensaje = $this->getMensajeModel()->buscarMensaje($id['idSimulacrogrupo']);
	    }else {
	        $mensaje = "token incorrecto";
	    }

	    return $mensaje;
	}
}
?>