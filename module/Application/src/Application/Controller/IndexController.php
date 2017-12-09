<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//Componentes necesarios para enviar el correo
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;

class IndexController extends AbstractActionController
{
    
    public function indexAction()
    {
        $config = $this->getServiceLocator()->get('Config');
        print_r($config);
        exit;
        $emailConfig = $config['email'];
        
        $html = new Part('<h3>Estou enviando este mensagem para você</h3>');
        $html->type = "text/html";
        
        $body = new Message();
        $body->setParts(array($html));
        
        
        $message = new Message();
        $message->addTo('vane.velascogtz@gmail.com')
        ->addFrom('pakodiazcastillo@gmail.com')
        ->setSubject('Enviando e-mail teste')
        ->setBody($body);
        
        $transport = new SmtpTransport();
        $options = new SmtpOptions([
            'name' => $emailConfig['host'],
            'host' => $emailConfig['host'],
            'connection_class' => $emailConfig['auth'],
            'port' => $emailConfig['port'],
            'connection_config' => [
                'username' => $emailConfig['username'],
                'password' => $emailConfig['password'],
                'ssl' => $emailConfig['ssl']
            ]
        ]);
        
        $transport->setOptions($options);
        $transport->send($message);
    }
    
    public function correoAction(){
        $destinatario='pakodiazcastillo@gmail.com';
        $emisor='vane.velascogtz@gmail.com';
        
        //Enviar email
        $message = new Message();
        $message->addTo($destinatario)
        ->addFrom($emisor)
        ->setEncoding("UTF-8")
        ->setSubject('Registro de usuarios correcto')
        ->setBody("Hola te has registrado correctamente en mi aplicación");
        
        // Utilizamos el smtp de gmail con nuestras credenciales
        $transport = new SmtpTransport();
        $options   = new SmtpOptions(array(
            'name'  => 'smtp.gmail.com',
            'host'  => 'smtp.gmail.com',
//             'ssl' => 'tls',
            'port'  => 587,
            'connection_class'  => 'login',
            'connection_config' => array(
                'username' => 'vane.velascogtz@gmail.com',
                'password' => 'blood@_92_',
                'ssl' => 'tls',
            ),
        ));
        $transport->setOptions($options); //Establecemos la configuración
        $transport->send($message); //Enviamos el correo
    }

    public function saludaAction(){
    	$response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "response" => "Esta es mi respuesta.",
            )));
            
        return $response;
    	exit;
    }

}
