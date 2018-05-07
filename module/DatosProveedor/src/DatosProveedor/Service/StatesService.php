<?php
namespace DatosProveedor\Services;

use DatosProveedor\Model\StatesModel;

class StatesService
{
	private $statesModel;
	
	// Instanciamos el modelo de estados de mexico
	public function getStatesModel()
	{
		return $this->statesModel = new StatesModel();
	}
	
	// Obtemos los estados de mexico
	public function fetchAll()
	{
		$states = $this->getStatesModel()->fetchAll();
		return $states;
	}
	
}