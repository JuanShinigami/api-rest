<?php
namespace Application\Service;

use Application\Model\PerfilModel;

class PerfilService
{

    private $perfilModel;

    private function getPerfilModel()
    {
        return $this->perfilModel = new PerfilModel();
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
        $perfil = $this->getPerfilModel()->getAll();
        
        return $perfil;
    }

    public function addPerfil($dataPerfil)
    {
        $token=$this->getValidarToken()->validaToken($dataPerfil);
        
        
        if ($token['status']) {
            
            $perfil = $this->getPerfilModel()->existe($dataPerfil);
            
            if (empty($perfil)) {
                $perfil = array("registro" =>$this->getPerfilModel()->addPerfil($dataPerfil),  "StatusToken" =>$token);
            } else {
                $perfil= "Este perfil ya esta registrado";
            }
        } else {
            $perfil = array(
                "Mensaje :" => "Acceso denegado",
                "flag :" => 'false',
                "StatusToken" =>$token
            );
        }
        return $perfil;
    }
}
?>