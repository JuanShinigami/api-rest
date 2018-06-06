<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\PerfilService;
use Application\Service\ClientesService;

class ClientesController extends AbstractActionController
{

    private $clienteService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getClienteService()
    {
        return $this->clienteService = new ClientesService();
    }

    public function listaAction(){

        $perfil = $this->getPerfilService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $perfil,
            )));
            
        return $response;
        //exit;
    }

    public function addClienteAction(){

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getClienteService()->addCliente($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
    public function eliminarClienteAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getClienteService()->eliminarCliente($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function busquedaClienteAction(){
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getClienteService()->buscarCliente($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>








