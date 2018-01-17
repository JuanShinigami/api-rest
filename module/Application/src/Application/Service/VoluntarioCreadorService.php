<?php
namespace Application\Service;

use Application\Model\VoluntarioCreadorModel;
use Zend\Validator\Identical;

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

    public function validaToken($decodePostData)
    {
//         print_r($decodePostData);
       
        $token = false;
        $valid = new Identical(array('token' => 'token'));//, 'strict' => FALSE)
        
        if ($valid->isValid($decodePostData['token'])) {
            $token=true;
        }
//         print_r($token);
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
        $token = $this->validaToken($decodePostData['token']);
        
        
        if ($token==true){
            
             $existeVolCreador = $this->getVolCreadorModel()->existe($decodePostData['folio']);
        }else {
            $existeVolCreador = "token incorrecto";
        }
        
       
        return $existeVolCreador;
    }
}
?>