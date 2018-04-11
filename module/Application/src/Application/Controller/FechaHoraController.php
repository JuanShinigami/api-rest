<?php
namespace Application\Controller;
use Application\Service\FechaHoraService;
use Zend\Mvc\Controller\AbstractActionController;

class FechaHoraController extends AbstractActionController
{

    private $mensajeService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getFechaHoraService()
    {
        return $this->fechaHoraService = new FechaHoraService();
    }

    public function fechaHoraAction(){

        $fechaHora = $this->getFechaHoraService()->getAll();
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => $fechaHora,
            )));
            
        return $response;
        //exit;
    }
   
}
?>