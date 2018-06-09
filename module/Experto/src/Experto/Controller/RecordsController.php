<?php
namespace Experto\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Experto\Service\RecordsService;

class RecordsController extends AbstractActionController
{

    private $recordsService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getRecordsService()
    {
        return $this->recordsService = new RecordsService();
    }

    public function indexAction(){
         echo "Hola";
    }
    public function listaAction(){

        $records = $this->getRecordsService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $records,
            )));
            
        return $response;
        //exit;
    }

    public function addRecordsAction(){

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getRecordsService()->addRecords($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
    public function editarRecordsAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecordsService()->editarRecords($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function busquedaRecordsAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecordsService()->buscarRecords($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>








