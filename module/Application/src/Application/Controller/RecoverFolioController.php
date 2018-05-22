<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Application\Service\RecuperarFolioService;


class RecoverFolioController extends AbstractActionController
{
    
    private $recuperaFolioService;
    
    /**
     * Instanciamos el servicio de participantes
     */
    public function getRecuperaFolioService()
    {
        return $this->recuperaFolioService = new RecuperarFolioService();
    }
    
    public function getAll(){
        $recuperaFolio = $this->getRecuperaFolioService()->getAll();
        
    }
    public function recoveraEmailAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getRecuperaFolioService()->recuperaCorreo($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
        }
        
        exit;
    }

    
   
}
?>