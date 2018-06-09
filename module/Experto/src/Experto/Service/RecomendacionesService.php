<?php
namespace Experto\Service;

use Experto\Model\RecomendacionesModel;

class RecomendacionesService
{

    private $recocomendacionesModel;

    private function getRecomendacionesModel()
    {
        return $this->recocomendacionesModel = new RecomendacionesModel();
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
        $recomendaciones = $this->getRecomendacionesModel()->getAll();
        
        return $recomendaciones;
    }

    public function addRecomendacion($dataRecomendacion)
    {
//         $token = $this->getValidarToken()->validaToken($dataCliente);
        
//         if ($token['status']) {
            
//             $records = $this->getRecordsModel()->existe($dataRecomendacion);

//             print_r($cliente);exit;
//             if (empty($records)) {
                $recomendacion = array(
                    "registro" => $this->getRecomendacionesModel()->addRecomendacion($dataRecomendacion),
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
        return $recomendacion;
    }
    
    public function editarRecomendacion($dataRecomendacion){
            // $token = $this->getValidarToken()->validaToken($dataCliente);
            
        // if ($token['status']) {
        
//         $recomendacion = $this->getRecomendacionesModel()->existe($dataRecomendacion);
        
//         print_r($records);exit;
//         if (!empty($recomendacion)) {
        $recomendacion = array(
            "editar" => $this->getRecomendacionesModel()->editarRecomendacion($dataRecomendacion),
            // "StatusToken" => $token
        );
//         }else {
//                  $recomendacion = " incorrecta";
//               }
        
        
//         print_r($cliente);exit; 
        
        //         } else {
        //             $perfil = array(
        //                 "Mensaje :" => "Acceso denegado",
        //                 "flag :" => 'false',
        //                 "StatusToken" => $token
        //             );
        //         }
        return $recomendacion;
    }
    
    
    public function buscarRecomendacion($dataRecomendacion){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        
        $recomendacion = array(
            "busqueda" => $this->getRecomendacionesModel()->buscarRecomendacion($dataRecomendacion),
            
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
        return $recomendacion;
    }
    
    
    public function eliminarRecomendacion($dataRecomendacion){
        // $token = $this->getValidarToken()->validaToken($dataCliente);
        
        // if ($token['status']) {
        $recomendacion = array(
            "registro" => $this->getRecomendacionesModel()->eliminarRecomendacion($dataRecomendacion),
            
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
        return $recomendacion;
    }
    
}










?>