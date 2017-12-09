<?php

namespace Application\Service;

use Application\Model\RecuperarFolioModel;
use Zend\View\Model\ViewModel;
use Application\Service\MensajeService;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;

class RecuperarFolioService
{
	private $recuperarFolioModel;
	
	private function getRecuperarFolioModel()
	{
		return $this->recuperarFolioModel = new RecuperarFolioModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$usuario = $this->getUsuarioModel()->getAll();

		return $usuario;
	}


	public function recuperaCorreo($dataUser)
	{
    
	   $usuario = $this->getRecuperarFolioModel()->recuperaCorreo($dataUser);
	   $this->correo($usuario);

		return $usuario;
	}
	
	public function correo($response){
	    //         $destinatario='ejemplo@gmail.com';
	    $destinatario=$response[0]['correo'];
	    $emisor='ejemplo@gmail.com';
	    
	    //Enviar email
	    $message = new Message();
	    $message->addTo($destinatario)
	    ->addFrom($emisor)
	    ->setEncoding("UTF-8")
	    ->setSubject('Envio de Folio')
	    ->setBody("Tu folio es: ".$response[0]['folio']);
	    
	    // Utilizamos el smtp de gmail con nuestras credenciales
	    $transport = new SmtpTransport();
	    $options   = new SmtpOptions(array(
	        'name'  => 'smtp.gmail.com',
	        'host'  => 'smtp.gmail.com',
	        'port'  => 587,
	        'connection_class'  => 'login',
	        'connection_config' => array(
	            'username' => 'ejemplo@gmail.com', // direccion de correo que mandara los correos
	            'password' => '****', // contraseña de correo 
	            'ssl' => 'tls',
	        ),
	    ));
	    $transport->setOptions($options); //Establecemos la configuración
	    $transport->send($message); //Enviamos el correo
	    exit;
	}
}
?>