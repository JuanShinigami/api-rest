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
	
}