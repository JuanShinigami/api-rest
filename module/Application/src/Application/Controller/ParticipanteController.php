<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\ParticipanteService;

class ParticipanteController extends AbstractActionController
{

    private $participanteService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getParticipanteService()
    {
        return $this->participanteService = new ParticipanteService();
    }

    public function listaAction(){

        $participantes = $this->getParticipanteService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $participantes,
            )));
            
        return $response;
        exit;
    }
}
?>