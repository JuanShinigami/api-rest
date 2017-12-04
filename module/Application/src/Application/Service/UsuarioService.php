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
		$usuario = $this->getUsuarioModel()->existe($dataUser);
		
		//print_r($dataUser['nombre']);
		
		if (empty($usuario[0]['id'])){
		    
		    $folioExtrae = substr($dataUser['nombre'],0,2);
		    $folioNuevo=$folioExtrae . 100;
		    echo "Extrae ".$folioExtrae;
		    echo "\n";
		    echo "folioNuevo ".$folioNuevo;
		   
		    $usuario = $this->getUsuarioModel()->addUsuarios($dataUser, $folioNuevo);
		    
		  
		}else {
		    
 
		    $folioExtrae = substr($usuario[0]['folio'],2);
		    echo "Extracion ".$folioExtrae."\n";
		    
		    $folioAct=$folioExtrae + 100;
		    echo "Suma ". $folioAct;
		    
		    
		    $folioNuevo=substr($dataUser['nombre'],0,2). $folioAct;
		    echo" \n";
		    echo "folio Actualizado ".$folioNuevo;
		    
		   // print_r($usuario);
		
		    $usuario = $this->getUsuarioModel()->updateUsuarios($usuario,$folioNuevo);
		}

		return $usuario;
	}
}
?>