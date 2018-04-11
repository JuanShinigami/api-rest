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
        $token=$this->getValidarToken()->validaToken($dataUser);
        
        if ($token['status']) {
            
            $usuario = $this->getRecuperarFolioModel()->recuperaCorreo($dataUser);
            $completo = array("correo"=>$this->correo($usuario), "StatusToken"=>$token);
            
        }else {
            $completo =  array("Mensaje :" => "Acceso denegado" , "flag :" => 'false', "token" =>$token);
        }
        
        return $completo;
    }

    
    public function correoToken($response)
    {
//         print_r("hola");
//         print_r($response['correo']);exit;
        $flag = false;
        try {
            
            // $destinatario='ejemplo@gmail.com';
            $destinatario = $response['correo'];
            $emisor = 'ejemplo@gmail.com';
            
            // Enviar email
            $message = new Message();
            $message->addTo($destinatario)
            ->addFrom($emisor)
            ->setEncoding("UTF-8")
            ->setSubject('Cuenta registrada')
//             ->setBody("Bienvenido " . $response['nombre'])
            ->setBody("Bienvenido " . $response['nombre'] ."\nTe has registrado exitosamente en Voluntario");
//             ->setBody('<html> <h1>Hola</h1>  </html>');
//             ->addPart('<h1>Mensaje enviado con Swiftmailer - Victor Robles</h1>', 'text/html');
            
            // Utilizamos el smtp de gmail con nuestras credenciales
            $transport = new SmtpTransport();
            $options = new SmtpOptions(array(
                'name' => 'smtp.gmail.com',
                'host' => 'smtp.gmail.com',
                'port' => 587,
                'connection_class' => 'login',
                'connection_config' => array(
                    'username' => 'ejemplo@gmail.com', // direccion de correo que mandara los correos
                    'password' => '*********', // contraseña de correo
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