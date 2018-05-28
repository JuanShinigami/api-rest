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
	
	public function addArticulo($articulo){
	    return $this->getTypePetModel()->addArticulo($articulo);
	}
	
	public function getArticulo($id){
	    return $this->getTypePetModel()->getArticulo($id);
	}
	
	public function updateArticulo($id,$articulo){
	    return $this->getTypePetModel()->updateArticulo($id, $articulo);
	}
	
	public function deletebyId($id)
	{
	    $tipoArticulo = $this->getTypePetModel()->deleteById($id);
	    return $tipoArticulo;
	}
	
}