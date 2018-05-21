<?php
namespace DatosProveedor\Services;

use DatosProveedor\Model\NeighborhoodModel;

class NeighborhoodService
{
	private $neighborhoodModel;
	
	// Instanciamos el modelo de colonias
	public function getNeighborhoodModel()
	{
		return $this->neighborhoodModel = new NeighborhoodModel();
	}
	
	// Obtemos las colonias
	public function fetchAll($id)
	{
		$neighborhood = $this->getNeighborhoodModel()->fetchAll($id);
		return $neighborhood;
	}
	
}