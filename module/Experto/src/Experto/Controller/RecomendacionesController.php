<?php
namespace Experto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Experto\Service\RecordsService;
use Experto\Service\RecomendacionesService;

class RecomendacionesController extends AbstractActionController
{

    private $recomendacionesService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getRecomendacionesService()
    {
        return $this->recomendacionesService = new RecomendacionesService();
    }

    public function indexAction(){
         echo "Hola";
    }
    public function listaAction(){

        $records = $this->getRecomendacionesService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $records,
            )));
            
        return $response;
        //exit;
    }

    public function addRecomendacionAction(){

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getRecomendacionesService()->addRecomendacion($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
    public function editarRecomendacionAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecomendacionesService()->editarRecomendacion($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function busquedaRecomendacionAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecomendacionesService()->buscarRecomendacion($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function eliminarRecomendacionAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecomendacionesService()->eliminarRecomendacion($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>








