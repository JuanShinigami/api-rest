<?php
namespace Experto\Service;

use Experto\Model\ClientesModel;
use Zend\Crypt\Password\Apache;
use Zend\Crypt\Password\Bcrypt;

class ClientesService
{

    private $clientesModel;

    private function getClientesModel()
    {
        return $this->clientesModel = new ClientesModel();
    }

    private $validarToken;

    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $perfil = $this->getClientesModel()->getAll();
        
        return $perfil;
    }

    public function addCliente($dataCliente)
    {
//         $token = $this->getValidarToken()->validaToken($dataCliente);
        
//         if ($token['status']) {
            
            $cliente = $this->getClientesModel()->existe($dataCliente);
            
            $securePass=$this->password($dataCliente['contrasena']);

//             print_r($cliente);exit;
            if (empty($cliente)) {
                $cliente = array(
                    "registro" => $this->getClientesModel()->addCliente($dataCliente, $securePass),
                    "idCliente"=>$this->getClientesModel()->idCliente()
                   // "StatusToken" => $token
                );
            } else {
                $cliente = "Cliente ya esta registrado";
            }
//         } else {
//             $perfil = array(
//                 "Mensaje :" => "Acceso denegado",
//                 "flag :" => 'false',
//                 "StatusToken" => $token
//             );
//         }
        return $cliente;
    }
    
    public function eliminarCliente($dataCliente){
            // $token = $this->getValidarToken()->validaToken($dataCliente);
            
        // if ($token['status']) {
        $cliente = array(
            "registro" => $this->getClientesModel()->eliminarClientes($dataCliente),
            
            // "StatusToken" => $token
        );
        
//         print_r($cliente);exit; 
        
        //         } else {
        //             $perfil = array(
        //                 "Mensaje :" => "Acceso denegado",
        //                 "flag :" => 'false',
        //                 "StatusToken" => $token
        //             );
        //         }
        return $cliente;
    }
    
    
    public function buscarCliente($dataCliente){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        $cliente = array(
            "busqueda" => $this->getClientesModel()->buscarCliente($dataCliente),
            
            // "StatusToken" => $token
        );
        
        //         print_r($cliente);exit;
        
        //         } else {
        //             $perfil = array(
        //                 "Mensaje :" => "Acceso denegado",
        //                 "flag :" => 'false',
        //                 "StatusToken" => $token
        //             );
        //         }
        return $cliente;
    }
    
    public function loginCliente($decodePostData)
    {
//         print_r($decodePostData);
        // if ($this->getValidarToken()->validaToken($decodePostData)){
        $array = array();
        $pass=$this->password($decodePostData['contrasena']);
        
//         print_r($pass);
        
        $loginCliente = $this->getClientesModel()->loginClientes($decodePostData, $pass);
        
//                 print_r($loginCliente);
//                 exit;
        //         print_r(" contrasena en base:   --------> ");
        //         print_r($registroVoluntario['datos'][0]['contrasena']);
        //         exit;
        $bcrypt = new Bcrypt();
        
        // var_dump($registroVoluntario['status'] === true);exit;
        if ($loginCliente['status'] === true) {
            
            //             $securePass = $registroVoluntario['datos'][0]['contrasena'];
            //             $password = $decodePostData['contrasena'];
            
            // if ($bcrypt->verify($password, $securePass)) {
            //                 echo "\nThe password is correct! \n";
            
            $generatoken = $this->getvalidartoken()->generartoken($decodePostData, $loginCliente);
            
            $array['registro'] = $loginCliente;
            $array['token'] = $generatoken;
            
            //             }else {
            // //                 echo "\nThe password is NOT correct.\n";
            //                 $array['mensaje'] = "Contraseña incorrecta";
            //             }
            
        } else {
            $array['mensaje'] = "Usuario y Contrasena incorrectos";
        }
        //         exit;
        // }else {
        // $registroVoluntario = array("Mensaje :" => "Acceso denegado" , "flag :" => 'false');
        // }
        
        return $array;
    }
    
    public function password($dataVolCreador){
        
        try{
            
            $apache = new Apache();
            $apache->setFormat('sha1');
            $apache->setFormat('digest');
            $apache->setUserName('enrico');
            $apache->setAuthName('test');
            $securePass = $apache->create($dataVolCreador);
            
        } catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        return $securePass;
    }
    
}










?>