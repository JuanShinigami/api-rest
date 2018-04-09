<?php
namespace Application\Service;

use Application\Model\VoluntarioCreadorModel;
use Application\Service\RecuperarFolioService;
use Zend\Crypt\Password\Bcrypt;

class VoluntarioCreadorService
{

    private $voluntarioCreadorModel;

    private $validarToken;
    
    private $correoToken;
    
    private function getcorreoTokenl()
    {
        return $this->correoToken = new RecuperarFolioService();
    }

    private function getVolCreadorModel()
    {
        return $this->voluntarioCreadorModel = new VoluntarioCreadorModel();
    }

    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
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
        // if ($this->getValidarToken()->validaToken($dataVolCreador)) {
        try {
            
            $usuarioCorreo = $this->getVolCreadorModel()->existeCorreo($dataVolCreador);
            $securePass=$this->password($dataVolCreador['contrasena']);
            
//             print_r($securePass);
            
            
            if (! empty($usuarioCorreo)) {
                
                $arrayResponse = array(
                    "flag" => 'false',
                    "Mensaje" => 'Este correo ya esta dado de alta'
                );
            } else {
                
                // $token = $this->validaToken($dataVolCreador);
                
                $usuario = $this->getVolCreadorModel()->addVolCreador($dataVolCreador,$securePass);

//                 print_r("usuario");
//                 exit;
//                 print_r($dataVolCreador);exit;
// *********************************
//                 $correo=$this->getcorreoTokenl()->correoToken($dataVolCreador);
                
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
        
        // }else{
        // $arrayResponse = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
        // }
        
        return $arrayResponse;
    }

   
    
    public function password($dataVolCreador){
        
        try{
            
            //         $bcrypt = new Bcrypt();
//             print_r("   Contrasena dada por usuario:  ");
//             print_r($dataVolCreador);
//             print_r("     ------   ");
            $bcrypt = new Bcrypt(array(
                'salt' => 'aleatorio_salt_voluntario_simulacros',
//                 'salt' => $dataVolCreador,
                'cost' => 13
                
            ));
            
//             var_dump($bcrypt);
            
            $securePass = $bcrypt->create($dataVolCreador);
//             print_r("   Contrasena encriptada:  ");
//             print_r($securePass);
//             print_r("     ------   ");
            
            
        } catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        return $securePass;
    }
    
    
    
    public function existeVolCreador($decodePostData)
    {
        
        // $token=$this->getValidarToken()->validaToken($decodePostData);
//         print_r($decodePostData);
//         exit;
        if ($this->getValidarToken()->validaToken($decodePostData)) {
            
            exit;
            $existeVolCreador = $this->getVolCreadorModel()->existe($decodePostData['correo']);
           
            if(!empty($existeVolCreador)){
                $existeVolCreador['token'] = $decodePostData['token'];
            }else{
                $existeVolCreador = array(
                    "Mensaje :" => "Correo incorrecto",
                    "flag :" => 'false'
                );
            }
            
            
            // print_r($existeVolCreador);
        } else {
            $existeVolCreador = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false'
            );
        }
        
        return $existeVolCreador;
    }

    public function registroVoluntario($decodePostData)
    {
        
        // if ($this->getValidarToken()->validaToken($decodePostData)){
        $array = array();
        $pass=$this->password($decodePostData['contrasena']);
       
        $registroVoluntario = $this->getVolCreadorModel()->registroVoluntario($decodePostData);
        
//         print_r($registroVoluntario);
//         print_r(" contrasena en base:   --------> ");
//         print_r($registroVoluntario['datos'][0]['contrasena']);
//         exit;
        $bcrypt = new Bcrypt();
        
        // var_dump($registroVoluntario['status'] === true);exit;
        if ($registroVoluntario['status'] === true) {
            $securePass = $registroVoluntario['datos'][0]['contrasena'];
            $password = $decodePostData['contrasena'];
            
            if ($bcrypt->verify($password, $securePass)) {
//                 echo "\nThe password is correct! \n";
                
                $generatoken = $this->getvalidartoken()->generartoken($decodePostData, $registroVoluntario);
                
                $array['registro'] = $registroVoluntario;
                $array['token'] = $generatoken;
                
            }else {
//                 echo "\nThe password is NOT correct.\n";
                $array['mensaje'] = "Contraseña incorrecta";
            }
            
        } else {
            $array['mensaje'] = "No existe usuario";
        }
//         exit;
        // }else {
        // $registroVoluntario = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
        // }
        
        return $array;
    }

    public function updateToken($decodePostData)
    {
        if ($this->getValidarToken()->validaToken($decodePostData)) {
            
            // var_dump($registroVoluntario['status'] === true);exit;
            
            $updateToken = $this->getValidarToken()->updateToken($decodePostData);
//             print_r("***********");
//            print_r($updateToken['status']);exit;
           
            $array = $updateToken;
            
        } else {
            $array = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false'
            );
        }
        return $array;
    }
}
?>