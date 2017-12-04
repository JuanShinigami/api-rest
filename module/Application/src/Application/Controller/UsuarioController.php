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

    public function agregarAction(){

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $decodePostData,
            )));
            echo print_r($decodePostData);exit;
        	//return $response; exit;
            
            // PARSEAMOS JSON A ARRAY PHP
    	}

    	$arrayUser = array("folio"=>2342,"nombre"=>"", "telefono"=>"34534534", "correo"=>"kdjsk@gmail.com");
    	$result = $this->getUsuarioService()->addUsuario($arrayUser);
    	echo "Este es el resultado de agregar usuario ---> ".$result;
    	exit;
    }

}