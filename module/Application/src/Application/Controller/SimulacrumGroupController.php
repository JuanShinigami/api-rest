<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de sismos
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\SimulacroGrupoService;

class SimulacrumGroupController extends AbstractActionController
{

    private $simulacroGrupoService;

    public function getSimulacroService()
    {
        return $this->simulacroGrupoService = new SimulacroGrupoService();
    }

    public function getAll(){
        $simulacroGrupo = $this->getSimulacroService()->getAll();    
    }
    
    public function addSimulacrumGroupAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getSimulacroService()->addSimulacro($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
        }
        exit();
    }
    
    public function countVoluntaryAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getSimulacroService()->countVoluntario($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
        }
        exit();
    }
     
    public function updateSimulacrumGroupAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getSimulacroService()->updateEstatus($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
        }
        exit();
    }
    
    public function searchSimulacrumDetailAction(){
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getSimulacroService()->buscarDetalles($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}