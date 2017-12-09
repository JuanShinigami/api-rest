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
    public function addUsuariosAction(){

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
          
    		$result = $this->getUsuarioService()->addUsuario($decodePostData);
    		
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
     
    	}

    	exit;
    }

}