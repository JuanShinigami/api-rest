<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de voluntario Creador
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\VoluntarioCreadorService;
use Zend\Http\Request;
use Zend\Http\Header\Cookie;

class VoluntaryCreatorController extends AbstractActionController
{

    private $voluntCreadorService;

    public function getVoluntCreadorService(){
    	return $this->voluntCreadorService = new VoluntarioCreadorService();
    }

    public function listaAction(){
        
        $voluntCreador = $this->getvoluntCreadorService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $voluntCreador,
        )));
        
        return $response;
        //exit;
    }
    public function addVoluntaryCreatorAction(){

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$postData       = $this->getRequest()->getContent();
    		$decodePostData = json_decode($postData, true);
          
    		$result = $this->getVoluntCreadorService()->addVolCreador($decodePostData);
//     		print_r($result);
//     		exit;
    		
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
     
    	}

    	exit;
    }
    
//     public function addGenerateTokenAction(){
//         $voluntCreador = $this->getvoluntCreadorService()->generarToken($arrayResponse);
//         $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//             "response" => $voluntCreador,
//         )));
        
//         return $response;
//     }
    
    public function existsVoluntaryCreatorAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getVoluntCreadorService()->existeVolCreador($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
            
        }
        
        exit;
    }
    
    public function registryVoluntaryCreatorAction(){
        print_r("hola ");
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            $result = $this->getVoluntCreadorService()->registroVoluntario($decodePostData);
            
//             print_r($result['token']);exit;
            
//             $token=$this->params()->fromRoute(,null);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
        
         return $response;
        }
            
            
           exit;
        }
        
        
   
    
    public function updateVoluntaryCreatorAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getVoluntCreadorService()->updateToken($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
            
        }
        
        exit;
    }

}