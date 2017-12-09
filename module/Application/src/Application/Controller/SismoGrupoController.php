<?php
/**
 * @autor JuanMS
 * Controlador para las peticiones de sismos
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\SismoGrupoService;

class SismoGrupoController extends AbstractActionController
{

    private $sismoGrupoService;

    public function getSismoService()
    {
        return $this->sismoGrupoService = new SismoGrupoService();
    }

    public function addSismoGrupoAction()
    {
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $postData = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);
            
            $result = $this->getSismoService()->addSismoGrupo($decodePostData);
            
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            
            return $response;
        }
        exit();
    }
}