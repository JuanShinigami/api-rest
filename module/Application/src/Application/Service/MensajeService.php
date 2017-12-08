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
	    $mensaje = $this->getMensajeModel()->addMensaje($dataMensaje);
	  	return $mensaje;
	}
	
	public function buscarMensaje($id)
	{
	    $mensaje = $this->getMensajeModel()->buscarMensaje($id);
	    
	    return $mensaje;
	}
}
?>