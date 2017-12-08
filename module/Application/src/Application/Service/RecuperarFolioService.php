<?php

namespace Application\Service;

use Application\Model\RecuperarFolioModel;

class RecuperarFolioService
{
	private $recuperarFolioModel;
	
	private function getRecuperarFolioModel()
	{
		return $this->recuperarFolioModel = new RecuperarFolioModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$usuario = $this->getUsuarioModel()->getAll();

		return $usuario;
	}


	public function recuperaCorreo($dataUser)
	{
    
	   $usuario = $this->getRecuperarFolioModel()->recuperaCorreo($dataUser);

		return $usuario;
	}
}
?>