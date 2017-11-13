<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\UsuarioService;
use Application\Service\ParticipanteSismoService;

class PruebaController extends AbstractActionController
{

    private $usuarioService;
    private $participanteSismoService;

    /**
     * Instanciamos el servicio de participantes
     */
    public function getUsuarioService()
    {
        return $this->usuarioService = new UsuarioService();
    }
    
    
	public function getParticipanteSismoService()
    {
        return $this->participanteSismoService = new ParticipanteSismoService();
    }
//
//    public function listaAction(){
//
//        $participantes = $this->getParticipanteService()->getAll();
//        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                "response" => $participantes,
//            )));
//            
//        return $response;
//        exit;
//    }
    
//	public function listaUsuariosAction(){
//
//        $usuarios = $this->getUsuariosService()->getAll();
//        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
//                "response" => $usuarios,
//            )));
//            
//        return $response;
//        exit;
//    }
    
    public function addUserAction(){
    	$arrayUser = array("folio"=>2342,"nombre"=>"Pepe shfjhsjkhfkjshdkfjhsdkjfhskjdfhksjdfhkjsdhjjkhdfkjshdkfjhskdjfhskjdfhksjdhfkjsdhfkjshdkjfhskdjfhksjdfhskjdfhkjh", "telefono"=>"34534534", "correo"=>"kdjsk@gmail.com");
    	$result = $this->getUsuarioService()->addUsuario($arrayUser);
    	echo "Este es el resultado de agregar usuario ---> ".$result;
    	exit;
    }
    
public function addUParticipanteSismoAction(){
    $arrayPartSismo = array("idParticipante"=>677,"idSismo"=>3244, "tiempo_inicio"=>3456, "tiempo_estoy_listo"=>6722);
    	$result = $this->getParticipanteSismoService()->addParticipanteSismo($arrayPartSismo);
    	echo "Este es el resultado de agregar usuario ---> ".$result;
    	exit;
    }
}



?>