<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Application\Service\MensajeService;
use Application\Service\RecuperarFolioService;
use Application\Service\SimulacroGrupoService;
use Application\Service\VoluntarioCreadorService;
use Application\Service\VoluntarioService;
use Application\Service\VoluntarioSimulacroService;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\View;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    private $voluntCreadorService;

    private $voluntarioService;

    private $voluntarioSimulacroService;

    private $simulacroGrupoService;

    private $recuperaFolioService;
    
    private $mensajeService;

    public function getVoluntCreadorService()
    {
        return $this->voluntCreadorService = new VoluntarioCreadorService();
    }

    public function getVoluntarioService()
    {
        return $this->voluntarioService = new VoluntarioService();
    }

    public function getVoluntarioSimulacroService()
    {
        return $this->voluntarioSimulacroService = new VoluntarioSimulacroService();
    }

    public function getSimulacroService()
    {
        return $this->simulacroGrupoService = new SimulacroGrupoService();
    }

    public function getRecuperaFolioService()
    {
        return $this->recuperaFolioService = new RecuperarFolioService();
    }
   
    
    public function getMensajeService()
    {
        return $this->mensajeService = new MensajeService();
    }

    public function indexAction()
    {
        
        
        $volCreador = $this->getVoluntCreadorService()->getAll();
        $voluntarios = $this->getVoluntarioService()->getAll();
        $voluntariosSimulacro = $this->getVoluntarioSimulacroService()->getAll();
        $simulacroGrupo = $this->getSimulacroService()->getAll();
        $recuperaFolio = $this->getRecuperaFolioService()->getAll();
        $mensaje = $this->getMensajeService()->getAll(); 
        
        $servicios = array();
        
        

        $servicios[0] = "Servicio de Voluntario creador -------> " . ((count($volCreador) >= 0)?'ok':'er');
        $servicios[1] = "Servicio de Voluntario -------> " . ((count($voluntarios) >= 0)?'ok':'er');
        $servicios[2] = "Servicio de Voluntario - Simulacro -------> " . ((count($voluntariosSimulacro) >= 0)?'ok':'er');
        $servicios[3] = "Servicio de Simulacro -------> " . ((count($simulacroGrupo) >= 0)?'ok':'er');
        $servicios[4] = "Servicio de Recuperar Folio -------> " . ((count($recuperaFolio) >= 0)?'ok':'er');
        $servicios[4] = "Servicio de Mensaje -------> " . ((count($mensaje) >= 0)?'ok':'er');
        
        
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => $servicios,
        )));
        
        return $response;
        
        exit();
    }

    public function correoAction()
    {
        $destinatario = 'pakodiazcastillo@gmail.com';
        $emisor = 'vane.velascogtz@gmail.com';
        
        // Enviar email
        $message = new Message();
        $message->addTo($destinatario)
            ->addFrom($emisor)
            ->setEncoding("UTF-8")
            ->setSubject('Registro de usuarios correcto')
            ->setBody("Hola te has registrado correctamente en mi aplicación");
        
        // Utilizamos el smtp de gmail con nuestras credenciales
        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'name' => 'smtp.gmail.com',
            'host' => 'smtp.gmail.com',
            // 'ssl' => 'tls',
            'port' => 587,
            'connection_class' => 'login',
            'connection_config' => array(
                'username' => 'vane.velascogtz@gmail.com',
                'password' => 'blood@_92_',
                'ssl' => 'tls'
            )
        ));
        $transport->setOptions($options); // Establecemos la configuración
        $transport->send($message); // Enviamos el correo
    }

    public function saludaAction()
    {
        $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
            "response" => "Esta es mi respuesta."
        )));
        
        return $response;
        exit();
    }
}
