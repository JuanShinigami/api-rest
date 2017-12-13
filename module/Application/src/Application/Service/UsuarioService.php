<?php
namespace Application\Service;

use Application\Model\UsuarioModel;

class UsuarioService
{

    private $usuarioModel;

    private function getUsuarioModel()
    {
        return $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $usuario = $this->getUsuarioModel()->getAll();
        
        return $usuario;
    }

    /**
     * public function addUsuario($dataUser)
     * {
     * // $arrayResponse;
     * // print_r($dataUser['nombre']);
     * // $nombre=$dataUser['nombre'];
     * // $arrayName = split(' ', $nombre);
     *
     * // $arrayName = split(' ', $dataUser['nombre']);
     *
     * // // echo "\narray name ";
     * // // print_r($arrayName);
     *
     * // $extraeNombre = '';
     * // // echo "\nCount".count($arrayName);
     *
     * // for($i=0; $i<count($arrayName); $i++){
     * // // print_r($arrayName);
     *
     * // $extraeNombre .= substr($arrayName[$i],0,1);
     * // // $nuevo = substr($arrayName[0],0,2);
     *
     * // }
     * // // print_r($extraeNombre);
     * // // echo "\n";
     * // $folioNuevo=$extraeNombre . 100;
     * // //echo $folioNuevo;
     *
     *
     * $usuarioCorreo = $this->getUsuarioModel()->existeCorreo($dataUser);
     *
     *
     * if (! empty($usuarioCorreo)) {
     *
     * $arrayResponse = array(
     * "flag" => 'false'
     * );
     * } else {
     * // print_r($dataUser['nombre']);
     * // exit;
     *
     * $arrayName = explode(' ', $dataUser['nombre']);
     * // $arrayName = split(' ', $dataUser['nombre']);
     *
     * echo "\narray name ";
     * print_r($arrayName);
     *
     *
     *
     * $extraeNombre = '';
     * echo "\nCount".count($arrayName);
     *
     *
     * for ($i = 0; $i < count($arrayName); $i ++) {
     * // print_r($arrayName);
     *
     * $extraeNombre .= substr($arrayName[$i], 0, 1);
     * // $nuevo = substr($arrayName[0],0,2);
     * }
     * // print_r($extraeNombre);
     * // echo "\n";
     * $folioNuevo = $extraeNombre . 100;
     * echo $folioNuevo;
     *
     *
     * $usuario = $this->getUsuarioModel()->existe($folioNuevo);
     *
     * //print_r("existe folio ".$folioNuevo);
     * exit;
     *
     *
     *
     * if (! empty($folioNuevo)) {
     *
     * for ($i = 0; $i < count($folioNuevo); $i ++) {
     *
     * //print_r($folioNuevo);
     *
     *
     * $folioExtrae = substr($folioNuevo, 2);
     *
     * //echo "Extracion ".$folioExtrae."\n";
     *
     * //$folioAct = $folioExtrae + 100;
     *
     * // echo "Suma ". $folioAct;
     *
     *
     * //$folioNuevo = substr($folioNuevo, 0, 2) . $folioAct;
     * // $folioRecorrido .= substr($arrayName[$i], 0, 1);
     * // $nuevo = substr($arrayName[0],0,2);
     * }
     * exit;
     *
     *
     *
     * // if (! empty($usuario[0]['id'])) {
     *
     * // print_r($folioNuevo);
     * // print_r($usuario[0]['id']);
     * // exit;
     * // $arrayName = explode(' ', $dataUser['nombre']);
     * // $arrayName = split(' ', $dataUser['nombre']);
     *
     * // // echo "\narray name ";
     * // // print_r($arrayName);
     *
     * // $extraeNombre = '';
     * // // echo "\nCount".count($arrayName);
     *
     * // for ($i = 0; $i < count($arrayName); $i ++) {
     * // // print_r($arrayName);
     *
     * // $extraeNombre .= substr($arrayName[$i], 0, 1);
     * // // $nuevo = substr($arrayName[0],0,2);
     * // }
     * // // print_r($extraeNombre);
     * // // echo "\n";
     * // $folioNuevo = $extraeNombre . 100;
     * // // echo $folioNuevo;
     * // $folioExtrae = substr($folioNuevo, 2);
     *
     * // // echo "Extracion ".$folioExtrae."\n";
     *
     * // $folioAct = $folioExtrae + 100;
     *
     * // // echo "Suma ". $folioAct;
     *
     * // $folioNuevo = substr($folioNuevo, 0, 2) . $folioAct;
     * // // echo" \n";
     * // // echo "folio Actualizado ".$folioNuevo;
     * // }
     * }
     *
     * $usuario = $this->getUsuarioModel()->addUsuarios($dataUser, $folioNuevo);
     * $arrayResponse = array(
     * "flag" => 'true',
     * "usuario" => $usuario
     * );
     * }
     * // echo print_r($arrayResponse);
     * // exit;
     *
     * return $arrayResponse;
     * }
     */
    public function addUsuario($dataUser)
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
            
            $usuarioCorreo = $this->getUsuarioModel()->existeCorreo($dataUser);
            
            // print_r($usuarioCorreo);
            
            if (! empty($usuarioCorreo)) {
                
                $arrayResponse = array(
                    "flag" => 'false'
                );
            } else {
                
                $arrayName = explode(' ', $dataUser['nombre']);
                $extraeNombre = '';
                // echo "\nCount".count($arrayName);
                
                for ($i = 0; $i < count($arrayName); $i ++) {
                    // print_r($arrayName);
                    
                    $extraeNombre .= strtoupper(substr($arrayName[$i], 0, 1));
                    // $nuevo = substr($arrayName[0],0,2);
                }
                // print_r($extraeNombre);
                // echo "\n";
                $maxFolio = $this->getUsuarioModel()->maxFolio($extraeNombre);
                
                if (! empty($maxFolio[0]["maxFolio"])) {
                    
                    $folioExtrae = substr($maxFolio[0]["maxFolio"], 2);
                    
                    $folioAct = $folioExtrae + 100;
                    
                    $folioNuevo = substr($maxFolio[0]["maxFolio"], 0, 2) . $folioAct;
                } else {
                    $folioNuevo = $extraeNombre . 100;
                }
                 
                $usuario = $this->getUsuarioModel()->addUsuarios($dataUser, $folioNuevo);
                $arrayResponse = array(
                    "flag" => 'true',
                    "usuario" => $usuario
                );
            }
        } catch (\PDOException $e) {
            // echo "First Message " . $e->getMessage() . "<br/>";
            $flag = false;
        } catch (\Exception $e) {
            // echo "Second Message: " . $e->getMessage() . "<br/>";
        }
        
        // echo print_r($arrayResponse);
        // exit;
        
        return $arrayResponse;
    }

    public function existeUsuario($decodePostData)
    {
        $existeUsuario = $this->getUsuarioModel()->existe($decodePostData['folio']);
        return $existeUsuario;
    }
}
?>