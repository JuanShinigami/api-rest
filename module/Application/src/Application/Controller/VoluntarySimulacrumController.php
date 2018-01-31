<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\VoluntarioSimulacroService;

class VoluntarySimulacrumController extends AbstractActionController
{

    private $voluntarioSimulacroService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getVoluntarioSimulacroService()
    {
        return $this->voluntarioSimulacroService = new VoluntarioSimulacroService();
    }

    public function listSimulacrumClientAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            $result = $this->getVoluntarioSimulacroService()->getAllByClient($decodePostData['idClient']);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        //exit;
    }

    public function listaAction(){

        $voluntariosSimulacro = $this->getVoluntarioSimulacroService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $voluntariosSimulacro,
            )));
            
        return $response;
        //exit;
    }

    public function addVoluntarySimulacrumAction(){


        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            $result = $this->getVoluntarioSimulacroService()->addVoluntarioSimulacro($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
    
    public function updateVoluntarySimulacrumAction(){
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getVoluntarioSimulacroService()->updateVoluntario($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function searchDetailVoluntaryAction(){
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getVoluntarioSimulacroService()->buscarDetalleVoluntario($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function deletelistVoluntaryAction(){
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getVoluntarioSimulacroService()->listaVoluntario($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    
    public function deteleVoluntaryOfSimulacrumAction(){
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getVoluntarioSimulacroService()->eliminarVolDeSimulacro($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}
?>