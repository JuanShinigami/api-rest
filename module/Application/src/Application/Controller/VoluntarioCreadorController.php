<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de voluntario Creador
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\VoluntarioCreadorService;

class VoluntarioCreadorController extends AbstractActionController
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
    public function addVoluntCreadorAction(){

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
    
    public function existeVoluntCreadorAction(){
        
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

}