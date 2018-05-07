<?php
namespace DatosProveedor\Services;

use DatosProveedor\Model\TypePetModel;

class TypePetService
{
	private $typePetModel;
	
	// Instanciamos el modelo de tipo de mascota
	public function getTypePetModel()
	{
		return $this->typePetModel = new TypePetModel();
	}
	
	// Obtemos los tipos de mscota
	public function fetchAll()
	{
		$typePets = $this->getTypePetModel()->fetchAll();
		return $typePets;
	}
	
}