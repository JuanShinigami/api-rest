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
	    print_r($mensaje);
		exit;

		return $mensaje;
	}
}
?>