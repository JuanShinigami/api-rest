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
    	$this->table      = 'empresa';
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
			->columns(array('id', 'nombre_empresa', 'descripcion_empresa', 'sitioWeb'))
			->from(array('c' => $this->table))
			->order('c.nombre_empresa ASC');
	
		$selectString = $sql->getSqlStringForSqlObject($select);
		$execute      = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
		$result       = $execute->toArray();
		return $result;
	}

	// Obtener proveedor por id de usuraio
	public function getSupplierById($idUser)
	{

		$sql = new Sql($this->dbAdapter);
    	$select = $sql->select();
    	$select
      		->columns(array('id', 'nombre_empresa', 'descripcion_empresa', 'sitioWeb'))
      		->from(array('c' => $this->table))

      		// JOIN TABLE ADDRESSES
      		->join(array('direccion' => 'direccion'), 'c.id = direccion.id_empresa', array('id_direccion', 'calle', 'codigoPostal', 'numero', 'id_estado', 'distrito', 'colonia'), 'Inner')

      		// JOIN TABLE COMPANY TYPE PET
      		//->join(array('c_t_p' => 'company_type_pet'), 'c.id_company = c_t_p.id_company', array('id_type_pet', 't_p_status' => 'status'), 'Inner')

      		// JOIN TABLE COMPANY ACTIVITY SECTOR
      		//->join(array('c_a_s' => 'company_activity_sector'), 'c.id_company = c_a_s.id_company', array('id_activity_sector', 'a_s_status' => 'status'), 'Inner')

      		// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
			->join(array('imagenes_empresa' => 'imagenes_empresa'), 'c.id_empresa = imagenes_empresa.id_empresa', array('id' => 'id', 'img_nombre' => 'nombre', 'img_desc' => 'descripcion'), 'Inner')

      		// JOIN TABLE USERS
      		->join(array('u' => 'usuarioProveedor'), 'c.id = u.id', array('correo', 'nombre' => 'nombre'), 'Inner')

      		// JOIN TABLE USERS DETAILS
//*********		->join(array('u_d' => 'users_details'), 'u.id = u_d.id_user', array('id_user' => 'id', 'name', 'surname', 'phone'), 'Inner')

      		->where(array('c.idUsuarioProveedor' => $idUser));
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
      		->columns(array('id', 'nombre_empresa', 'descripcion_empresa', 'sitioWeb'))
      		->from(array('c' => $this->table))

      		// JOIN TABLE ADDRESSES
      		->join(array('direccion' => 'direccion'), 'c.id = direccion.id_empresa', array('id_direccion', 'calle', 'codigoPostal', 'numero', 'id_estado', 'distrito', 'colonia'), 'Inner')

      		// JOIN TABLE STATES OF MEXICO
      		->join(array('s_m' => 'estados_de_mexico'), 'direccion.id_estado = s_m.id', array('nombre_estado' => 'estado'), 'Inner')

      		// JOIN TABLE DISTRICT
      		->join(array('d' => 'distrito'), 'direccion.distrito = d.id', array('nombre_distrito' => 'nombre'), 'Inner')

      		// JOIN TABLE NEIGBORHOOD
      		->join(array('n' => 'colonia'), 'direccion.colonia = n.id', array('nombre_colonia' => 'colonia'), 'Inner')

      		// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
			->join(array('imagenes_empresa' => 'imagenes_empresa'), 'c.id = imagenes_empresa.id_empresa', array('id_img' => 'id', 'img_nombre' => 'nombre', 'img_desc' => 'descripcion'), 'Inner')

      		// JOIN TABLE USERS
      		->join(array('u' => 'usuarioProveedor'), 'c.idUsuarioProveedor = u.id', array('correo', 'nombre_usuario' => 'nombre'), 'Inner')

      		// JOIN TABLE USERS DETAILS
//       		->join(array('u_d' => 'users_details'), 'u.id = u_d.id_user', array('id_user' => 'id', 'name', 'surname', 'phone'), 'Inner')

      		->where(array('c.id' => $idCompany));
  
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
			->columns(array('id', 'nombre_empresa', 'descripcion_empresa', 'sitioWeb'))

			// TABLA PRINCIPAL
			->from(array('c' => $this->table))

			// JOIN TABLE ADDRESSES
		    ->join(array('direccion' => 'direccion'), 'c.id = direccion.id_empresa', array('id_direccion', 'calle', 'codigoPostal', 'numero', 'id_estado', 'distrito', 'colonia'), 'Inner')

      		// JOIN TABLE STATES OF MEXICO
		    ->join(array('s_m' => 'estados_de_mexico'), 'direccion.id_estado = s_m.id', array('nombre_estado' => 'estado'), 'Inner')

      		// JOIN TABLE DISTRICT
		->join(array('d' => 'distrito'), 'direccion.distrito = d.id', array('nombre_distrito' => 'nombre'), 'Inner')

			// JOIN TABLA DE ANUNCIOS DE PROVEEDOR
		->join(array('imagenes_empresa' => 'imagenes_empresa'), 'c.id = imagenes_empresa.id_empresa', array('id_img' => 'id', 'img_nombre' => 'nombre', 'img_desc' => 'descripcion'), 'Left')

			// JOIN TABLA DE COMPANY TYPE PET empresa_tipo_articulo
			->join(array('e_t_a' => 'empresa_tipo_aticulo'), 'c.id = e_t_a.id_empresa', array('id_tipo_aticulo', 'e_t_a_status' => 'estatus'), 'Inner')

			// JOIN TABLE COMPANY ACTIVITY SECTOR empresa_sector_actividad
      		->join(array('e_s_a' => 'empresa_sector_actividad'), 'c.id = e_s_a.id_empresa', array('id_sector_actividad', 'e_s_a_estatus' => 'estatus'), 'Inner')

			// CONDICIONAL DE ID DE TYPE PET
// ***************			->where(array('c_t_p.id_type_pet' => $formData['pet_type']))

			// CONDICIONAL DE ID DE ACTIVITY SECTOR
			->where(array('e_s_a.id_sector_actividad' => $formData['sector_actividad']))

			// CONDICIONAL DE STATUS DE TYPE PET
			->where(array('c_t_p.status' => 1))

			// CONDICIONAL DE STATUS DE ACTIVITY SECTOR
			->where(array('e_s_a.estatus' => 1))

			// CONDICIONAL DE ID DE ESTADO
			->where(array('direccion.id_estado' => $formData['estados_de_mexico']));

			// ***************************************
			// VALIDAMOS SI EL DISTRITO TIENE UN VALOR
			// ***************************************
			if($formData['distrito'] != 0 && $formData['distrito'] != "") {
				
				// CONDICIONAL DE ID DE DELEGACION O MUNICIPIO
				$select->where(array('direccion.distrito' => $formData['distrito']));

			}	

			// ORDENAMOS LA LISTA DE RESULTADOS
			$select->order('c.nombre_empresa ASC');
	
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
  
      		$supplier  		= $this->update($data, array("id" => $data['id']));
      		$updateSupplier = $data['id'];
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
