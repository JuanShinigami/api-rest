<?php
namespace Application\Service;

use Application\Model\SimulacroGrupoModel;
use Application\Model\VoluntarioSimulacroModel;

class SimulacroGrupoService
{

    private $simulacroGrupoModel;

    private $voluntCreadorService;

    private $voluntarioSimulacroModel;

    private function getSimulacroGrupoModel()
    {
        return $this->simulacroGrupoModel = new SimulacroGrupoModel();
    }

    private function getVoluntarioSimulacroModel()
    {
        return $this->voluntarioSimulacroModel = new VoluntarioSimulacroModel();
    }

    private $validarToken;

    private function getValidarToken()
    {
        return $this->validarToken = new ValidarTokenService();
    }

    public function getVoluntCreadorService()
    {
        return $this->voluntCreadorService = new VoluntarioCreadorService();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $simulacroGrupo = $this->getSimulacroGrupoModel()->getAll();
        
        return $simulacroGrupo;
    }

    public function addSimulacro($dataSimulacroGrupo)
    {
        try {
            $resArray = array();
            
            $token=$this->getValidarToken()->validaToken($dataSimulacroGrupo);
            if ($token['status']) {
                
//                 print_r("entro al token   ");
//                 print_r($dataSimulacroGrupo);exit;

                
//                 $arrayName = explode(' ', $dataSimulacroGrupo['tagGrupal']);
//                 $extraeNombre = '';
//                 // echo "\nCount".count($arrayName);
                
//                 for ($i = 0; $i < count($arrayName); $i ++) {
//                     // print_r($arrayName);
                    
//                     $extraeNombre .= strtoupper(substr($arrayName[$i], 0, 1));
//                     // $nuevo = substr($arrayName[0],0,2);
//                 }
// //                 print_r($extraeNombre);
// //                 exit;
//                 // echo "\n";
//                 $maxFolio = $this->getSimulacroGrupoModel()->maxFolio($extraeNombre);
                
//                 // print_r($maxFolio);exit;
                
//                 if (! empty($maxFolio[0]["maxFolio"])) {
                    
//                     $folioExtrae = substr($maxFolio[0]["maxFolio"], 2);
                    
//                     $folioAct = $folioExtrae + 100;
                    
//                     $folioNuevo = substr($maxFolio[0]["maxFolio"], 0, 2) . $folioAct;
//                 } else {
//                     $folioNuevo = $extraeNombre . 100;
//                     // print_r($folioNuevo);exit;
//                 }

//                 print_r($this->randomLetras()."".$this->randomLetras()."".$this->randomLetras()."".$this->randomLetras());
                $letras=$this->randomLetras()."".$this->randomLetras()."".$this->randomLetras()."".$this->randomLetras();
                
                $numero = rand(1, 100);
                
//                 print_r($numero%10);
                
//                 exit;
                
            if(strlen($numero)== 3){
//                     print_r("3*****");
                    
//                     print_r($numero);
                    
            }else if (strlen($numero)== 2){
//                     print_r("2****");
                    
                    $numero= 0 . $numero;
//                     print_r($numero);
                }else{
//                     print_r("1*****");
                    
                    $numero='00'.$numero;
//                     print_r($numero);
                }
                
                
                
                $folioNuevo=$letras.$numero;
                
//                 print_r($folioNuevo);exit;
                
                
                $simulacroGrupo = $this->getSimulacroGrupoModel()->addSimulacroGrupo($dataSimulacroGrupo, $folioNuevo);
                
//                 print_r($folioNuevo);exit;
                // print_r(" ------- > ");
                $idSimulacro = $this->getSimulacroGrupoModel()->idSimulacro($dataSimulacroGrupo);
                
                $dataVolSimulacro = array();
//                 $dataVolSimulacro['idVoluntario'] = $dataSimulacroGrupo['idVoluntarioCreador'];
//                 $dataVolSimulacro['idSimulacro'] = $idSimulacro;
//                 $dataVolSimulacro['tipoSimulacro'] = $dataSimulacroGrupo['tipoSimulacro'];
                
                // print_r($dataVolSimulacro);exit;
                
//                 $voluntarioSimulacroId = $this->getVoluntarioSimulacroModel()->addVoluntarioSimulacro($dataVolSimulacro);
                
                $resArray['agrego'] = $simulacroGrupo;
                $resArray['folio'] = $folioNuevo;
//                 $resArray['voluntarioSimulacro'] = $voluntarioSimulacroId;
                $resArray['idSimulacrum'] = $idSimulacro;
            } else {
                $resArray['Mensaje'] = "Acceso denegado";
                $resArray['flag'] = 'false';
                $resArray['token'] = $token;
                
            }
        } catch (\PDOException $e) {
            echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        return $resArray;
    }
    
    
    
    public function randomLetras(){
        $cadena = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        $numero = rand(0, 25);
                
        return $cadena[$numero];
        
    }
    
    
    

    public function countVoluntario($decodePostData)
    {
        $countVoluntary = $this->getVoluntarioSimulacroModel()->numeroVoluntario($decodePostData['idSimulacro']);
        return $countVoluntary;
    }

    public function updateEstatus($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        
        if ($token['status']) {
            
            
            $detalles = $this->getSimulacroGrupoModel()->updateEstatusSimulacro($decodePostData);
        } else {
            $detalles = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "token" =>$token
            );
        }
        return $detalles;
    }

    public function buscarDetalles($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
            
         if ($token['status']) {
            $detalles = $this->getSimulacroGrupoModel()->buscarDetalles($decodePostData);
        } else {
            $detalles = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "token" =>$token
            );
        }
        return $detalles;
    }
    
    
    public function buscarPorIdSimulacro($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        
        if ($token['status']) {
            $detalles = $this->getSimulacroGrupoModel()->searchSimulacrum($decodePostData);
        } else {
            $detalles = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "token" =>$token
            );
        }
        return $detalles;
    }
    
    public function buscarPorFolioSimulacro($decodePostData)
    {
        $token=$this->getValidarToken()->validaToken($decodePostData);
        
        if ($token['status']) {
            $detalles = $this->getSimulacroGrupoModel()->searchSimulacrumFolio($decodePostData);
        } else {
            $detalles = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "token" =>$token
            );
        }
        return $detalles;
    }
}
?>