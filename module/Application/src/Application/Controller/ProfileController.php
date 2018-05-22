<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\PerfilService;

class ProfileController extends AbstractActionController
{

    private $perfilService;

    /**
     * Instanciamos el servicio de voluntarios
     */
    public function getPerfilService()
    {
        return $this->perfilService = new PerfilService();
    }

    public function listaAction(){

        $perfil = $this->getPerfilService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $perfil,
            )));
            
        return $response;
        //exit;
    }

    public function addProfileAction(){

        $request = $this->getRequest();
        if ($request->isPost()) {
            $postData       = $this->getRequest()->getContent();
            $decodePostData = json_decode($postData, true);

            
            $result = $this->getPerfilService()->addPerfil($decodePostData);
                   
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $result,
            )));
            return $response;
        }

        exit;
    }
}
?>








