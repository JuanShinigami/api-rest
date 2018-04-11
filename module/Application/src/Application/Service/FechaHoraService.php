<?php

namespace Application\Service;

use Application\Model\MensajeModel;

class FechaHoraService
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
// 		$fechaHora = $this->getMensajeModel()->getAll();
        $array=array();
        
	    $fecha=date("Y"."-"."m"."-"."d"); 
	    $hora=date("G".":"."i".":"."s");

	    $array['fecha']=$fecha;
	    $array['hora']=$hora;
	    
		return $array;
	}


	public function addMensaje($dataMensaje)
	{
	    $token=$this->getValidarToken()->validaToken($dataMensaje);
	    
	    
	    if ($token['status']) {
	  	    $mensaje = $this->getMensajeModel()->addMensaje($dataMensaje);
	  	}else {
	  	    $mensaje = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false', "token" =>$token);
	  	}
	  	
	  	return $mensaje;
	}
	
	public function buscarMensaje($id)
	{
	    $token=$this->getValidarToken()->validaToken($id);
	        
	    if ($token['status']) {
	            
	        $mensaje = $this->getMensajeModel()->buscarMensaje($id['idSimulacrogrupo']);
	    }else {
	        $mensaje = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false',"token" =>$token);
	    }
	    
	    return $mensaje;
	}
}
?>