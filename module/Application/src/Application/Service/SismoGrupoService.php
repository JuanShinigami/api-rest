<?php

namespace Application\Service;

use Application\Model\SismoGrupoModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class SismoGrupoService
{
	private $sismoGrupoModel;
	
	private function getSismoGrupoModel()
	{
		return $this->sismoGrupoModel = new SismoGrupoModel();
	}

	/**
	* Obtenermos todos los participantes
	*/
	public function getAll()
	{
		$sismoGrupo = $this->getSismoGrupoModel()->getAll();

		return $sismoGrupo;
	}


	public function addSismoGrupo($dataSismoGrupo)
	{
		
		$sismoGrupo = $this->getSismoGrupoModel()->addSismoGrupo($dataSismoGrupo);
		print_r($sismoGrupo);
		exit;

		return $sismoGrupo;

	}

	public function buscarDetalles($id) {
	    
	    $detalles = $this->getSismoGrupoModel()->buscarDetalles($id);
	    
	    return $detalles;

	    
	}
	
	
	
	
}
?>