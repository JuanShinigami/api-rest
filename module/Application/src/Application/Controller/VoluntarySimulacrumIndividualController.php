<?php
namespace Application\Controller;
use Application\Service\VoluntarioSimulacroIndividualService;
use Zend\Mvc\Controller\AbstractActionController;

class VoluntarySimulacrumIndividualController extends AbstractActionController
{
    private $voluntarioSimulacroIndividualService;
    
    public function getVoluntarioSimulacroIndivudualService()
    {
        return $this->voluntarioSimulacroIndividualService = new VoluntarioSimulacroIndividualService();
    }
    
    public function addVoluntarySimulacrumIndividualAction(){
              
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getVoluntarioSimulacroIndivudualService()->addVoluntarioSimulacro($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
    public function deteleVoluntaryOfSimulacrumIndividualAction(){
              
        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            
            $result = $this->getVoluntarioSimulacroIndivudualService()->eliminarVolDeSimulacroIndividual($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }
        
        exit;
    }
}