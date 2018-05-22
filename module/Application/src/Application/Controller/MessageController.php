<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\MensajeService;

class MessageController extends AbstractActionController
{

    private $mensajeService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getMensajeService()
    {
        return $this->mensajeService = new MensajeService();
    }

    public function listaAction(){

        $mensaje = $this->getMensajeService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $mensaje,
            )));
            
        return $response;
        //exit;
    }

    public function addMessageAction(){


        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getMensajeService()->addMensaje($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    public function searchMessageAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getMensajeService()->buscarMensaje($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>