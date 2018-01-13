<?php
namespace Application\Service;

use Application\Model\VoluntarioModel;

class VoluntarioService
{

    private $voluntarioModel;

    private function getVoluntariosModel()
    {
        return $this->voluntarioModel = new VoluntarioModel();
    }

    /**
     * Obtenermos todos los participantes
     */
    public function getAll()
    {
        $participantes = $this->getVoluntariosModel()->getAll();
        
        return $participantes;
    }

    public function addVoluntario($dataVoluntario)
    {
        $voluntario = $this->getVoluntariosModel()->existe($dataVoluntario);
        
        if (empty($voluntario)) {
            $voluntario = $this->getVoluntariosModel()->addVoluntario($dataVoluntario);
        } else {
            $voluntario = "Usted ya esta registrado con el alias: " . $voluntario[0]['alias'];
        }
        return $voluntario;
    }
}
?>