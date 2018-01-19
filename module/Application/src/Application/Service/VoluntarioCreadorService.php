<?php
namespace Application\Service;

use Application\Model\VoluntarioCreadorModel;
use Zend\Config\Factory;
use Zend\Validator\Identical;
use Zend\Config\Config;

class VoluntarioCreadorService
{

    private $voluntarioCreadorModel;

    private function getVolCreadorModel()
    {
        return $this->voluntarioCreadorModel = new VoluntarioCreadorModel();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $volCreador = $this->getVolCreadorModel()->getAll();
        
        return $volCreador;
    }

    public function addVolCreador($dataVolCreador)
    {
        // $arrayResponse;
        // print_r($dataUser['nombre']);
        // $nombre=$dataUser['nombre'];
        // $arrayName = split(' ', $nombre);
        
        // $arrayName = split(' ', $dataUser['nombre']);
        
        // // echo "\narray name ";
        // // print_r($arrayName);
        
        // $extraeNombre = '';
        // // echo "\nCount".count($arrayName);
        
        // for($i=0; $i<count($arrayName); $i++){
        // // print_r($arrayName);
        
        // $extraeNombre .= substr($arrayName[$i],0,1);
        // // $nuevo = substr($arrayName[0],0,2);
        
        // }
        // // print_r($extraeNombre);
        // // echo "\n";
        // $folioNuevo=$extraeNombre . 100;
        // //echo $folioNuevo;
        try {
            
            $usuarioCorreo = $this->getVolCreadorModel()->existeCorreo($dataVolCreador);
            
            // print_r($usuarioCorreo);
            
            if (! empty($usuarioCorreo)) {
                
                $arrayResponse = array(
                    "flag" => 'false'
                );
            } else {
                
                $arrayName = explode(' ', $dataVolCreador['nombre']);
                $extraeNombre = '';
                // echo "\nCount".count($arrayName);
                
                for ($i = 0; $i < count($arrayName); $i ++) {
                    // print_r($arrayName);
                    
                    $extraeNombre .= strtoupper(substr($arrayName[$i], 0, 1));
                    // $nuevo = substr($arrayName[0],0,2);
                }
                // print_r($extraeNombre);
                // echo "\n";
                $maxFolio = $this->getVolCreadorModel()->maxFolio($extraeNombre);
                
                if (! empty($maxFolio[0]["maxFolio"])) {
                    
                    $folioExtrae = substr($maxFolio[0]["maxFolio"], 2);
                    
                    $folioAct = $folioExtrae + 100;
                    
                    $folioNuevo = substr($maxFolio[0]["maxFolio"], 0, 2) . $folioAct;
                } else {
                    $folioNuevo = $extraeNombre . 100;
                }
//                 $token = $this->validaToken($dataVolCreador);
                
                $usuario = $this->getVolCreadorModel()->addVolCreador($dataVolCreador, $folioNuevo);
                $arrayResponse = array(
                    "flag" => 'true',
                    "usuario" => $usuario
                );
            }
        } catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        
        // echo print_r($arrayresponse);
        // exit;
        
        
        return $arrayResponse;
    }

    
    public function generarToken($arrayResponse){
        
        print_r($arrayResponse);
//         $integer = Rand::getInteger(0,1000);
//         //         printf("Random integer in [0-1000]: %d\n", $integer);
        
//         $guarda = $this->guardaToken($integer);
//         return $integer;
//        $conf = new Factory();
       
        $config = Factory::fromFile('config/module.config.php', true); // Create a Zend Config Object
        
       
//         echo "config: ";
//         print_r($config);
        
        if ($arrayResponse == true) {
            
            $tokenId    = base64_encode(mcrypt_create_iv(32));
            $issuedAt   = time();
            $notBefore  = $issuedAt + 10;             //Adding 10 seconds
            $expire     = $notBefore + 60;            // Adding 60 seconds
            $serverName = $config->get('serverName'); // Retrieve the server name from config file
            
            /*
             * Create the token as an array
             */
            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
//                 'data' => [                  // Data related to the signer user
//                     'id'   => $arrayResponse['id'], // userid from the users table
//                     'userName' => $username, // User name
//                 ]
            ];
        }
        
        print_r($data);
        return $data;
             
    }
    

    
    public function validaToken($decodePostData)
    {
//         print_r($decodePostData);
        
        $token = false;
        
        $valid = new Identical(array('token' => 'token','strict' => FALSE));//, )
        
        if ($valid->isValid($decodePostData['token'])) {
           
            $token=true;
            
        }
//          print_r($token);
//          exit;
        return $token;
        
    }
    
    
    
//     public function hacerToken(){
       
//         $ config  =  array (
//             'callbackUrl'  =>  'http://example.com/callback.php' ,
//             'siteUrl'  =>  'http://twitter.com/oauth' ,
//             'consumerKey'  =>  'gg3DsFTW9OU9eWPnbuPzQ' ,
//             'consumerSecret'  =>  'tFB0fyWLSMf74lkEu9FTyoHXcazOWpbrAjTCCK48A'
//         );
//         $ consumer  =  new  ZendOAuth \ Consumer ( $ config );
//     }

    public function existeVolCreador($decodePostData)
    {
        
//         print_r($decodePostData);
       
        
//         $existeVolCreador = $this->getVolCreadorModel()->existe($decodePostData['folio']);
        
// //         print_r($existeVolCreador);
// //     echo "<br />";
        
//         if (empty($existeVolCreador)) {
            
//             $arrayResponse = array(
//                 "flag" => 'false'
//             );
//         } else {
            
//             $arrayResponse = array(
//                 "flag" => 'true',
//                 "id" => $existeVolCreador
//             );
//         }

//         $generaToken =$this->generarToken($arrayResponse);
// //        print_r($generaToken);
//         print_r($arrayResponse);
//         exit;

        
        $token = $this->validaToken($decodePostData);
        
              
        if ($token==true){
            
             $existeVolCreador = $this->getVolCreadorModel()->existe($decodePostData['folio']);
        }else {
            $existeVolCreador = "token incorrecto";
        }
        
       
        return $existeVolCreador;
        
        
    }
}
?>