    <?php
namespace Supplier\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class CompanyTypePetModel extends TableGateway
{
	private $dbAdapter;
	
	public function __construct()
   	{
   		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'empresa_tipo_aticulo';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
   	}
	
   	// Todos los contactos
	public function fetchAll()
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->from(array('e_t_a' => $this->table))
			->order('e_t_a.id ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	// Obtener tipos de mascota por id de proveedor
	public function getCompanyTypePetById($idCompny)
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id', 'id_empresa', 'id_tipo_aticulo', 'estatus'))
			->from(array('e_t_a' => $this->table))

			// JOIN A LA TABLA DE TYPE PET
			->join(array('t_a' => 'tipo_aticulo'), 'e_t_a.id_tipo_aticulo = t_a.id', array('nombre_tipo' => 'tipo', 'orden_articulo' => 'orden_articulo'), 'Inner')

			->order('t_a.orden_articulo ASC')
			->where(array('e_t_a.id_empresa' => $idCompny));
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}
	
	// Agregar
	public function addCompanyTypePet($data)
	{
		$connection = null;
	
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
	
			/* Ejecutar una o mas consultas aqui */
			foreach($data as $ctp) {
				$companyTypePet     = $this->insert($ctp);
				$saveCompanyTypePet = $this->getLastInsertValue();
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			// Tratamiento de errores
			$saveCompanyTypePet = $e->getCode();
		}
	
		return $saveCompanyTypePet;
	}
	
	// Modificar
	public function editCompanyTypePet($data)
	{
		//echo "<pre>"; print_r($data); exit;
		$connection = null;
		
		try {
			$connection = $this->dbAdapter->getDriver()->getConnection();
			$connection->beginTransaction();
		
			// Ejecutar una o mas consultas aqui
			foreach($data as $ctp) {
				$companyTypePet     = $this->update($ctp, array("id" => $ctp['id']));
				$editCompanyTypePet[] = $ctp['id'];
			}

			$connection->commit();
		}
		catch (\Exception $e) {
			
			if ($connection instanceof \Zend\Db\Adapter\Driver\ConnectionInterface) {
				$connection->rollback();
			}

			$dataErrors = array(
				"code" 		=> $e->getCode(),
				"message" 	=> $e->getMessage(),
				"file" 		=> $e->getFile(),
				"line" 		=> $e->getLine()
				
			);

			// Tratamiento de errores
			$editCompanyTypePet = $dataErrors;
		}

		return $editCompanyTypePet;

	}
}