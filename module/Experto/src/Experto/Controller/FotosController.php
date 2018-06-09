<?php
namespace Experto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Experto\Service\RecordsService;
use Experto\Service\RecomendacionesService;
use Experto\Service\FotosService;

class FotosController extends AbstractActionController
{

    private $fotosService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getFotosService()
    {
        return $this->fotosService = new FotosService();
    }

    public function indexAction(){
         echo "Hola";
    }
    public function listaAction(){

        $records = $this->getFotosService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $records,
            )));
            
        return $response;
        //exit;
    }

    public function addFotosAction(){

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getFotosService()->addFotos($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
    
    public function busquedaFotosAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getFotosService()->buscarFotos($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function eliminarFotosAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getFotosService()->eliminarFotos($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>








