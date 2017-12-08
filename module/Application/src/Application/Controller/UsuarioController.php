<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de usuarios
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\UsuarioService;

class UsuarioController extends AbstractActionController
{

    private $usuarioService;

    public function getUsuarioService(){
    	return $this->usuarioService = new UsuarioService();
    }

    public function listaAction(){
        
        $usuario = $this->getUsuarioService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $usuario,
        )));
        
        return $response;
        //exit;
    }
    public function agregarAction(){

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
          
    		$result = $this->getUsuarioService()->addUsuario($decodePostData);
    		
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $decodePostData,
            )));
            
            return $response;
            //echo print_r($decodePostData);exit;
        	//return $response; exit;
            // PARSEAMOS JSON A ARRAY PHP
            //echo print_r($result);exit;
    	}

    	exit;
    }

}