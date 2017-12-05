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
// 	    print_r($dataUser['nombre']);
	   
// 	    $nombre=$dataUser['nombre'];
// 	    $arrayName = split(' ', $nombre);

	    $arrayName = split(' ', $dataUser['nombre']);
	    
// 	    echo "\narray name "; 
// 	    print_r($arrayName);
	    
	    $extraeNombre = '';
// 	    echo "\nCount".count($arrayName);  
	    
	    
	    for($i=0; $i<count($arrayName); $i++){
// 	        print_r($arrayName);
	        
	      $extraeNombre .= substr($arrayName[$i],0,1);
	     // $nuevo = substr($arrayName[0],0,2);
	      
	    }
// 	    print_r($extraeNombre);
// 	    echo "\n";
	   $folioNuevo=$extraeNombre . 100;
	   //echo  $folioNuevo;
	   
	   
	    
	   $usuario = $this->getUsuarioModel()->existe($folioNuevo);
		
		//print_r($dataUser['nombre']);
		
	   exit;
	  
		if (empty($usuario[0]['id'])){
		    

		   $usuario = $this->getUsuarioModel()->addUsuarios($dataUser, $folioNuevo);
 
		}else {
		    
 
		    $folioExtrae = substr($folioNuevo,2);
		   
		    echo "Extracion ".$folioExtrae."\n";
		    
		    $folioAct=$folioExtrae + 100;
		    
		    echo "Suma ". $folioAct;
		   
		    
		    $folioNuevo=substr($folioNuevo,0,2). $folioAct;
		    echo" \n";
		    echo "folio Actualizado ".$folioNuevo;
		  
		
// 	   $usuario = $this->getUsuarioModel()->updateUsuarios($usuario,$folioNuevo);
		    $usuario = $this->getUsuarioModel()->addUsuarios($dataUser, $folioNuevo);
		}

		return $usuario;
	}
}
?>