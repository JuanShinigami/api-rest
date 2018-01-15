<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\VoluntarioService;

class VoluntaryController extends AbstractActionController
{

    private $voluntarioService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getVoluntarioService()
    {
        return $this->voluntarioService = new VoluntarioService();
    }

    public function listaAction(){

        $voluntarios = $this->getVoluntarioService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $voluntarios,
            )));
            
        return $response;
        //exit;
    }

    public function addVoluntaryAction(){


        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getVoluntarioService()->addVoluntario($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
}
?>