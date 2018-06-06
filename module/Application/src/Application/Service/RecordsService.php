<?php
namespace Application\Service;

use Application\Model\ClientesModel;
use Application\Model\RecordsModel;

class RecordsService
{

    private $recordsModel;

    private function getRecordsModel()
    {
        return $this->recordsModel = new RecordsModel();
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
        $records = $this->getRecordsModel()->getAll();
        
        return $records;
    }

    public function addRecords($dataRecords)
    {
//         $token = $this->getValidarToken()->validaToken($dataCliente);
        
//         if ($token['status']) {
            
            $records = $this->getRecordsModel()->existe($dataRecords);

//             print_r($cliente);exit;
            if (empty($records)) {
                $records = array(
                    "registro" => $this->getRecordsModel()->addRecords($dataRecords),
//                     "idCliente"=>$this->getClientesModel()->idCliente()
                   // "StatusToken" => $token
                );
            } else {
                $records = "Record ya esta registrado";
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