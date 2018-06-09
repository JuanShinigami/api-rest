<?php
namespace Experto\Service;

use Experto\Model\ClientesModel;

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

//             print_r($cliente);exit;
            if (empty($cliente)) {
                $cliente = array(
                    "registro" => $this->getClientesModel()->addCliente($dataCliente),
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
    
}










?>