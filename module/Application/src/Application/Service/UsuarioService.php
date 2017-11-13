<?php

namespace Application\Service;

use Application\Model\UsuarioModel;

class UsuarioService
{
	private $usuarioModel;
	
	private function getUsuarioModel()
	{
		return $this->usuarioModel = new UsuarioModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$usuario = $this->getUsuarioModel()->getAll();

		return $usuario;
	}


	public function addUsuario($dataUser)
	{
		$usuario = $this->getUsuarioModel()->addUsuarios($dataUser);
		print_r($usuario);
		exit;

		return $usuario;
	}
}
?>