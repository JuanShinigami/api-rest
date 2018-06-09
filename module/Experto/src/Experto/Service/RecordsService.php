<?php
namespace Experto\Service;

use Experto\Model\RecordsModel;

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
            
//             $records = $this->getRecordsModel()->existe($dataRecords);

//             print_r($cliente);exit;
//             if (empty($records)) {
                $records = array(
                    "registro" => $this->getRecordsModel()->addRecords($dataRecords),
//                     "idCliente"=>$this->getClientesModel()->idCliente()
                   // "StatusToken" => $token
                );
//             } else {
//                 $records = "Record ya esta registrado";
//             }
//         } else {
//             $perfil = array(
//                 "Mensaje :" => "Acceso denegado",
//                 "flag :" => 'false',
//                 "StatusToken" => $token
//             );
//         }
        return $records;
    }
    
    public function editarRecords($dataRecords){
            // $token = $this->getValidarToken()->validaToken($dataCliente);
            
        // if ($token['status']) {
        
        $records = $this->getRecordsModel()->existe($dataRecords);
        
//         print_r($records);exit;
        if (!empty($records)) {
        $records = array(
            "editar" => $this->getRecordsModel()->editarRecords($dataRecords),
            // "StatusToken" => $token
        );
        }else {
                 $records = "ubicacion incorrecta";
              }
        
        
//         print_r($cliente);exit; 
        
        //         } else {
        //             $perfil = array(
        //                 "Mensaje :" => "Acceso denegado",
        //                 "flag :" => 'false',
        //                 "StatusToken" => $token
        //             );
        //         }
        return $records;
    }
    
    
    public function buscarRecords($dataRecords){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        
        $records = array(
            "busqueda" => $this->getRecordsModel()->buscarRecords($dataRecords),
            
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
        return $records;
    }
    
}










?>