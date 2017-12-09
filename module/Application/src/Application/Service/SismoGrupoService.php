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
		
		return $sismoGrupo;

	}

	public function buscarDetalles($decodePostData) {
	    
	    $detalles = $this->getSismoGrupoModel()->buscarDetalles($decodePostData);
	    
	    return $detalles;

	    
	}
	
	
	
	
}
?>