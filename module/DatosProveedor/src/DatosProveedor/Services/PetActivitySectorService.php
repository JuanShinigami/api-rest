<?php
namespace DatosProveedor\Services;

// use DatosProveedor\Model\PetActivitySectorModel;
use DatosProveedor\Model\PetActivitySectorModel;

class PetActivitySectorService
{
    private $petActivitySectorModel;
    
    // Instanciamos el modelo de sector de actividad
    public function getPetActivitySectorModel()
    {
        return $this->petActivitySectorModel = new PetActivitySectorModel();
    }
    
    // Obtemos los sectores de actividad
    public function fetchAll()
    {
        $petActivitySector = $this->getPetActivitySectorModel()->fetchAll();
        return $petActivitySector;
    }
    
    public function deletebyId($id)
    {
        $petActivitySector = $this->getPetActivitySectorModel()->deletebyId($id);
        return $petActivitySector;
    }
    
    public function addSector($sector){
        return $this->getPetActivitySectorModel()->addSector($sector);
    }
    
    public function getSector($id){
        return $this->getPetActivitySectorModel()->getSector($id);
    }
    
    public function updateSector($id,$sector){
        return $this->getPetActivitySectorModel()->updateSector($id,$sector);
    }
    
}