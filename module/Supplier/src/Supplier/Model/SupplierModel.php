<?php
namespace Supplier\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class SupplierModel extends TableGateway
{
	private $dbAdapter;

	public function __construct()
	{
		$this->dbAdapter  = \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::getStaticAdapter();
    	$this->table      = 'company';
       	$this->featureSet = new Feature\FeatureSet();
     	$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
    	$this->initialize();
	}

	// Obtener todos los registros
	public function fetchAll()
	{
		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			->columns(array('id_company', 'name_company', 'company_description', 'website'))
			->from(array('c' => $this->table))
			->order('c.name_company ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	// Obtener proveedor por id de usuraio
	public function getSupplierById($idUser)
	{
	    print_r($idUser);

		$sql = new Sql($this->dbAdapter);
    	$select = $sql->select();
    	$select
      		->columns(array('id_company', 'name_company', 'company_description', 'website'))
      		->from(array('c' => $this->table))

      		// JOIN TABLE ADDRESSES
      		->join(array('address' => 'addresses'), 'c.id_company = address.company_id', array('id_address', 'street', 'postalcode', 'number', 'state_id', 'district', 'neighborhood'), 'Inner')

      		// JOIN TABLE COMPANY TYPE PET
      		//->join(array('c_t_p' => 'company_type_pet'), 'c.id_company = c_t_p.id_company', array('id_type_pet', 't_p_status' => 'status'), 'Inner')

      		// JOIN TABLE COMPANY ACTIVITY SECTOR
      		//->join(array('c_a_s' => 'company_activity_sector'), 'c.id_company = c_a_s.id_company', array('id_activity_sector', 'a_s_status' => 'status'), 'Inner')

      		// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
			->join(array('img_comp' => 'images_company'), 'c.id_company = img_comp.id_company', array('id_img' => 'id', 'img_name' => 'name', 'img_desc' => 'description'), 'Inner')

      		// JOIN TABLE USERS
      		->join(array('u' => 'users'), 'c.id_users = u.id', array('email', 'profile' => 'perfil'), 'Inner')

      		// JOIN TABLE USERS DETAILS
      		->join(array('u_d' => 'users_details'), 'u.id = u_d.id_user', array('id_user' => 'id', 'name', 'surname', 'phone'), 'Inner')

      		->where(array('c.id_users' => $idUser));
      		//->where(array('r_q.foliocodeqr' => $codeQR));
  
    	$selectString = $sql->getSqlStringForSqlObject($select);
    	$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    	$result       = $execute->toArray();

    	return $result;
		
	}

	// Obtener proveedor por id de proveedor
	public function getSupplierByIdCompany($idCompany)
	{

		$sql = new Sql($this->dbAdapter);
    	$select = $sql->select();
    	$select
      		->columns(array('id_company', 'name_company', 'company_description', 'website'))
      		->from(array('c' => $this->table))

      		// JOIN TABLE ADDRESSES
      		->join(array('address' => 'addresses'), 'c.id_company = address.company_id', array('id_address', 'street', 'postalcode', 'number', 'state_id', 'district', 'neighborhood'), 'Inner')

      		// JOIN TABLE STATES OF MEXICO
      		->join(array('s_m' => 'states_of_mexico'), 'address.state_id = s_m.id', array('name_state' => 'state'), 'Inner')

      		// JOIN TABLE DISTRICT
      		->join(array('d' => 'district'), 'address.district = d.id', array('name_district' => 'name'), 'Inner')

      		// JOIN TABLE NEIGBORHOOD
      		->join(array('n' => 'neighborhood'), 'address.neighborhood = n.id', array('name_neighborhood' => 'colony'), 'Inner')

      		// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
			->join(array('img_comp' => 'images_company'), 'c.id_company = img_comp.id_company', array('id_img' => 'id', 'img_name' => 'name', 'img_desc' => 'description'), 'Inner')

      		// JOIN TABLE USERS
      		->join(array('u' => 'users'), 'c.id_users = u.id', array('email', 'profile' => 'perfil'), 'Inner')

      		// JOIN TABLE USERS DETAILS
      		->join(array('u_d' => 'users_details'), 'u.id = u_d.id_user', array('id_user' => 'id', 'name', 'surname', 'phone'), 'Inner')

      		->where(array('c.id_company' => $idCompany));
  
    	$selectString = $sql->getSqlStringForSqlObject($select);
    	$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
    	$result       = $execute->toArray();

    	return $result;

	}

	// Obtener todos los registros por filtro
	public function fetchAllByFilter($formData)
	{
		//echo "<pre>"; print_r($formData); exit;

		$sql    = new Sql($this->dbAdapter);
		$select = $sql->select();
		$select
			// COLUMNAS DE LA TABLA PRINCIPAL
			->columns(array('id_company', 'name_company', 'company_description', 'website'))

			// TABLA PRINCIPAL
			->from(array('c' => $this->table))

			// JOIN TABLE ADDRESSES
      		->join(array('address' => 'addresses'), 'c.id_company = address.company_id', array('id_address', 'street', 'postalcode', 'number', 'state_id', 'district', 'neighborhood'), 'Inner')

      		// JOIN TABLE STATES OF MEXICO
      		->join(array('s_m' => 'states_of_mexico'), 'address.state_id = s_m.id', array('name_state' => 'state'), 'Inner')

      		// JOIN TABLE DISTRICT
      		->join(array('d' => 'district'), 'address.district = d.id', array('name_district' => 'name'), 'Inner')

			// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
			->join(array('img_comp' => 'images_company'), 'c.id_company = img_comp.id_company', array('id_img' => 'id', 'img_name' => 'name', 'img_desc' => 'description'), 'Left')

			// JOIN TABLA DE COMPANY TYPE PET
			->join(array('c_t_p' => 'company_type_pet'), 'c.id_company = c_t_p.id_company', array('id_type_pet', 't_p_status' => 'status'), 'Inner')

			// JOIN TABLE COMPANY ACTIVITY SECTOR
      		->join(array('c_a_s' => 'company_activity_sector'), 'c.id_company = c_a_s.id_company', array('id_activity_sector', 'a_s_status' => 'status'), 'Inner')

			// CONDICIONAL DE ID DE TYPE PET
			->where(array('c_t_p.id_type_pet' => $formData['pet_type']))

			// CONDICIONAL DE ID DE ACTIVITY SECTOR
			->where(array('c_a_s.id_activity_sector' => $formData['sector_activity']))

			// CONDICIONAL DE STATUS DE TYPE PET
			->where(array('c_t_p.status' => 1))

			// CONDICIONAL DE STATUS DE ACTIVITY SECTOR
			->where(array('c_a_s.status' => 1))

			// CONDICIONAL DE ID DE ESTADO
			->where(array('address.state_id' => $formData['state_of_mexico']));

			// ***************************************
			// VALIDAMOS SI EL DISTRITO TIENE UN VALOR
			// ***************************************
			if($formData['district'] != 0 && $formData['district'] != "") {
				
				// CONDICIONAL DE ID DE DELEGACION O MUNICIPIO
				$select->where(array('address.district' => $formData['district']));

			}	

			// ORDENAMOS LA LISTA DE RESULTADOS
			$select->order('c.name_company ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	/**
	 * MODIFICAR UN PROVEEDOR
	 */
	public function updateSupplier($data)
	{
		$connection = null;
  
    	try {
      		$connection = $this->dbAdapter->getDriver()->getConnection();
      		$connection->beginTransaction();
  
      		$supplier  		= $this->update($data, array("id_company" => $data['id_company']));
      		$updateSupplier = $data['id_company'];
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
			$updateSupplier = $dataErrors;
    	}

    	return $updateSupplier;
	}

}
