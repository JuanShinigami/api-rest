<?php
namespace Experto\Service;

use Experto\Model\FotosModel;

class FotosService
{

    private $fotosModel;

    private function getFotosModel()
    {
        return $this->fotosModel = new FotosModel();
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
        $fotos = $this->getFotosModel()->getAll();
        
        return $fotos;
    }

    public function addFotos($dataFotos)
    {
//         $token = $this->getValidarToken()->validaToken($dataCliente);
        
//         if ($token['status']) {
            
//             $records = $this->getRecordsModel()->existe($dataRecomendacion);

//             print_r($cliente);exit;
//             if (empty($records)) {
                $fotos = array(
                    "registro" => $this->getFotosModel()->addFotos($dataFotos),
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
        return $fotos;
    }
    
    public function buscarFotos($dataFotos){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        
        $fotos = array(
            "busqueda" => $this->getFotosModel()->buscarFotos($dataFotos),
            
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
        return $fotos;
    }
    
    
    public function eliminarFotos($dataFotos){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        $fotos = array(
            "registro" => $this->getFotosModel()->eliminarFotos($dataFotos),
            
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
        return $fotos;
    }
    
}










?>