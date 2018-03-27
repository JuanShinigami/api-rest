<?php
namespace Application\Service;

use Application\Model\RecuperarFolioModel;
use Zend\View\Model\ViewModel;
use Application\Service\MensajeService;
use Zend\Mail\Message;
use Exception;
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
    private $voluntCreadorService;
    
    private $validarToken;
    
    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
    }
    public function getVoluntCreadorService(){
        return $this->voluntCreadorService = new VoluntarioCreadorService();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $usuario = $this->getRecuperarFolioModel()->getAll();
        
        return $usuario;
    }

    public function recuperaCorreo($dataUser)
    {
        if($this->getValidarToken()->validaToken($dataUser)){
            $usuario = $this->getRecuperarFolioModel()->recuperaCorreo($dataUser);
            $completo = $this->correo($usuario);
        }else {
            $completo =  array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
        }
        
        return $completo;
    }

    
//     public function correoToken($response)
//     {
// //         print_r("hola");
// //         print_r($response['correo']);exit;
//         $flag = false;
//         try {
            
//             // $destinatario='ejemplo@gmail.com';
//             $destinatario = 'vaneinuyasha@gmail.com'; //$response['correo'];
//             $emisor = 'vane.velascogtz@gmail.com';
            
//             // Enviar email
//             $message = new Message();
//             $message->addTo($destinatario)
//             ->addFrom($emisor)
//             ->setEncoding("UTF-8")
//             ->setSubject('Cuenta registrada')
// //             ->setBody("Bienvenido " . $response['nombre'])
// //             ->setBody("Bienvenido " . $response['nombre'] ."\nTe has registrado exitosamente en Voluntario");
// //             ->setBody('<html> <h1>Hola</h1>  </html>');
//             ->addPart('<h1>Mensaje enviado con Swiftmailer - Victor Robles</h1>', 'text/html');
            
//             // Utilizamos el smtp de gmail con nuestras credenciales
//             $transport = new SmtpTransport();
//             $options = new SmtpOptions(array(
//                 'name' => 'smtp.gmail.com',
//                 'host' => 'smtp.gmail.com',
//                 'port' => 587,
//                 'connection_class' => 'login',
//                 'connection_config' => array(
//                     'username' => 'vane.velascogtz@gmail.com', // direccion de correo que mandara los correos
//                     'password' => 'blood@_92_', // contraseña de correo
//                     'ssl' => 'tls'
//                 )
//             ));
//             $transport->setOptions($options); // Establecemos la configuración
//             $transport->send($message); // Enviamos el correo
//             $flag=true;
//         } catch (Exception $e) {
//             $flag=false;
//             echo "First Message " . $e->getMessage() . "<br/>";
//             exit;
//         }
        
//         $response['status'] = $flag;
//         return $response;
        
//     }
    
    
    
    
    
    public function correoToken($response){
        // Podemos incluir la libreria de esta forma
        // require_once './vendor/librerias/Swift-5.0.3/lib/swift_required.php';
        
        /*
         *   Creamos la instancia para el transporte SMTP
         *  le indicamos el servidor smtp a utilizar y el puerto
         *  le indicamos el usuario y la contraseña
         *  de nuestra cuenta de correo
         */
        try{  $transport= \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587 )//'ssl' = 'tls')
        ->setUsername('vane.velascogtz@gmail.com')
        ->setPassword('blood@_92');
        // Creamos el mensaje
        $message = \Swift_Message::newInstance()
        
        //Al ser un formulario de contacto nos lo enviamos a nosotros mismos
        ->setTo(array(
            "vaneinuyasha@gmail.com" => "Contacto Victor Robles",
        ))
        
        // Definimos el asunto
        ->setSubject("Pruebas")
        
        // Escribimos el mensaje en html
        ->addPart('<h1>Mensaje enviado con Swiftmailer - Victor Robles</h1>', 'text/html')
        
        // Indicamos que el mensaje llega desde nuestra cuenta de correo
        ->setFrom("vane.velascogtz@gmail.com", "Correo con Swiftmailer")
        
        // Añadimos un archivo adjunto que esta el directorio public
        ->attach(\Swift_Attachment::fromPath("public/img/zf2-logo.png"));
        
        // Enviamos el email
        $mailer = \Swift_Mailer::newInstance($transport);
        $mailer->send($message);
        $flag=true;
      } catch (Exception $e) {
          $flag=false;
          echo "First Message " . $e->getMessage() . "<br/>";
          exit;
      }
      
      $response['status'] = $flag;
      return $response;
//         MAIL_DRIVER=smtp; MAIL_HOST=smtp.gmail.com; MAIL_PORT=465; MAIL_USERNAME=mail@gmail.com MAIL_PASSWORD=12345678 MAIL_ENCRYPTION=ssl;
        
        //$this->redirect()->toRoute("usuarios");
    }
    
    
    
    public function correo($response)
    {
        $flag = false;
        try {
            
            // $destinatario='ejemplo@gmail.com';
            $destinatario = $response[0]['correo'];
            $emisor = 'ejemplo@gmail.com';
            
            // Enviar email
            $message = new Message();
            $message->addTo($destinatario)
                ->addFrom($emisor)
                ->setEncoding("UTF-8")
                ->setSubject('Envio de Folio')
                ->setBody("Tu folio es: " . $response[0]['folioSimulacro']);
            
            // Utilizamos el smtp de gmail con nuestras credenciales
            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                'name' => 'smtp.gmail.com',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => array(
                    'username' => 'ejemplo@gmail.com', // direccion de correo que mandara los correos
                    'password' => '**********', // contraseña de correo
                    'ssl' => 'tls'
                )
            ));
            $transport->setOptions($options); // Establecemos la configuración
            $transport->send($message); // Enviamos el correo
            $flag=true;
        } catch (Exception $e) {
            $flag=false;
            echo "First Message " . $e->getMessage() . "<br/>";
            exit;
        }
        
        $response['status'] = $flag;
        return $response;
        
    }
}
?>