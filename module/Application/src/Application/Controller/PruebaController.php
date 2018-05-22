<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Service\UsuarioService;
use Application\Service\ParticipanteSismoService;
use Application\Service\ParticipanteService;
use Application\Service\SismoGrupoService;
use Application\Service\MensajeService;

class PruebaController extends AbstractActionController
{

    private $usuarioService;
    private $participanteSismoService;
    private $participanteService;
    private $serviceGrupo;
    private $mensaje;
    

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
    
    public function getParticipanteService()
    {
        return $this->participanteService = new ParticipanteService();
    }
    
    public function getSismoGrupoService()
    {
        return $this->sismoGrupoService = new SismoGrupoService();
    }
    
    public function getMensajeService()
    {
        return $this->mensaje = new MensajeService();
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

    
    public function addUserAction(){
    	$arrayUser = array("nombre"=>"Pamela Velasco", "telefono"=>"888888", "correo"=>"0pamela@gmail.com");
//     	$result = $this->getUsuarioService()->addUsuario($arrayUser);
    	$result = $this->getUsuarioService()->addUsuario($arrayUser);
    	echo "Este es el resultado de agregar usuario ---> ".$result["flag"];
    	exit;
    }
    
    public function addParticipanteSismoAction(){
    
        $arrayPartSismo = array("idParticipante"=>677,"idSismo"=>3244, "tiempo_inicio"=>3456, "tiempo_estoy_listo"=>6722);
    	$result = $this->getParticipanteSismoService()->addParticipanteSismo($arrayPartSismo);
    	echo "Este es el resultado de agregar usuario ---> ".$result;
    	exit;
    }
    
public function addParticipanteAction(){
        $arrayParticipante = array("idParticipante"=>111,"alias"=>"Pamela");
        $result = $this->getParticipanteService()->addParticipante($arrayParticipante);
        echo "Este es el resultado de agregar usuario ---> ".$result;
        exit;
    }
    
    public function addSismoGrupoAction(){
        $arraySismoGrupol = array("ubicacion"=>"92738723","fecha"=>"12-12-17", "hora"=>"13:44","participantes"=>"100","idUsuarios"=>1);
        $result = $this->getSismoGrupoService()->addSismoGrupo($arraySismoGrupol);
        echo "Este es el resultado de agregar usuario ---> ".$result;
        exit;
    }
    
    public function addMensajeAction(){
        $arrayMensaje = array("mensajeCreador"=>"akjshjajdjsekkwhiuedjmansxkjas","idSismogrupo"=>1);
        $result = $this->getMensajeService()->addMensaje($arrayMensaje);
        echo "Este es el resultado de agregar usuario ---> ".$result;
        exit;
    }
    
    
    public function buscarMensajeAction(){
        
        $buscaMsj = $this->getParticipanteService()->getAll();
        $buscaMsj = $this->getMensajeService()->buscarMensaje(1);
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $buscaMsj,
        )));
    
       return $response;
       exit;
    }
    public function buscarDetallesAction(){
        
        $buscaDetalle = $this->getSismoGrupoService()->buscarDetalles(1);
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $buscaDetalle,
        )));
        
        return $response;
        exit;
    }
    
    public function buscarDetallesParticipanteAction(){
        
        $buscaDetalleParticipante = $this->getParticipanteSismoService()->buscarDetalleParticipante(1);
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $buscaDetalleParticipante,
        )));
        
        return $response;
        exit;
    }
    
    
}



?>