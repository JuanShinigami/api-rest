<?php
namespace Supplier\Controller;

use DatosProveedor\Controller\BaseController;
use DatosProveedor\Form\UsersForm;
use DatosProveedor\Service\UsersService;
// use Users\Form\UsersForm;
// use Users\Service\UsersService;
// use DatosProveedor\Services\PetActivitySectorService;
use DatosProveedor\Services\TypePetService;
use Supplier\Service\CompanySectorActivityService;
use Supplier\Service\CompanyTypePetService;
use Supplier\Service\SupplierService;
use Zend\View\Model\ViewModel;
use Supplier\Model\SupplierModel;
use DatosProveedor\Model\UsersModel;
use DatosProveedor\Model\TypePetModel;
use DatosProveedor\Model\PetActivitySectorModel;
use Supplier\Model\CompanyTypePetModel;
use Supplier\Model\CompanySectorActivityModel;

class IndexController extends BaseController
{
    private $typePetService;
    private $petActivitySector;
    private $supplierService;
    private $companyTypePetService;
    private $companySectorActivityService;

    // Instnciamos servicio de proveedores
    private function getSupplierService()
    {
//         return $this->supplierService = new SupplierService();
        return $this->supplierService = new SupplierModel();
    }

	// Instanciamos servicio de companias
    public function getUsersServices()
    {
//         return $this->usersServices = new UsersService();
        return $this->usersServices = new UsersModel();
    }

    // Instanciamos servicio de tipos de mascota
    private function getTypePetService()
    {
//         return $this->typePetService = new TypePetService();
        return $this->typePetService = new TypePetModel();
    }

    // Instanciamos servicio de sector de actividad
    private function getPetActivitySectorService()
    {
//         return $this->petActivitySector = new PetActivitySectorService();
        return $this->petActivitySector = new PetActivitySectorModel();
    }

    // Instaciamos servicio de company type pet service
    private function getCompanyTypePetService()
    {
//         return $this->companyTypePetService = new CompanyTypePetService();
        return $this->companyTypePetService = new CompanyTypePetModel();
    }

    // Instanciamos servicio de company activity sector
    private function getCompanySectorActivityService()
    {
//         return $this->companySectorActivityService = new CompanySectorActivityService();
        return $this->companySectorActivityService = new CompanySectorActivityModel();
    }

	public function indexAction()
	{
        // ID DE USUARIO DE SESION
        $form           = new UsersForm("company_update_form");

        $idUser         = (int) $this->getIdUserSesion();

        // TIPO DE USUARIO
        $profileUser    = (int) $this->getPerfilUserSesion();

        // PERFIL
        $profile        = $this->getUsersServices()->getAll($idUser);//(15); //($idUser);
        //echo "<pre>"; print_r($profile); exit;

        // OBTENER PROVEEDOR POR ID
        $supplier       = $this->getSupplierService()->getSupplierById($idUser);//(15); //($idUser);
        //echo "<pre>"; print_r($supplier); exit;

        // Anuncios de compania
        $getCompanyNotice           = $supplier[0]['imgs_company'];

        // Obtenemos lista de tipos de mascotas por id de proveedor
        $getCompanyTypePet          = $this->getCompanyTypePetService()->getCompanyTypePetById($supplier[0]['id_company']);
        //echo "<pre>"; print_r($getCompanyTypePet); exit;

        // Obtenemos lista de sector de actividad por id de proveedor
        $getCompanySectorActivity   = $this->getCompanySectorActivityService()->getCompanySectorActivityById($supplier[0]['id_company']);
        //echo "<pre>"; print_r($getCompanySectorActivity); exit;

        // REQUEST
        $request                    = $this->getRequest();

        // VALIDAR EL TIPO DE PETICION
        if ($request->isPost()) {

            // Datos que vienen por post
            $formData = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );
            //echo "<pre>"; print_r($formData); exit;

            // modificar proveedor
            $updateSupplier = $this->getSupplierService()->updateSupplier($formData);
            //echo "<pre>"; print_r($updateSupplier); exit;

            if ($updateSupplier) {
                $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                    "status" => 'ok'
                )));
            } else {
                $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                    "status" => 'fail'
                )));
            }
            
            return $response;
        }
        
        // ******************************************
        // DATOS PARA RELLENAR EL FORMULARIO
        // ******************************************

        // Correo electronico
        $supplier[0]['email_user']          = $supplier[0]['email'];
        $supplier[0]['repeat_email_user']   = $supplier[0]['email'];

        // Nombre de usuario
        $supplier[0]['name_user']           = $supplier[0]['name'];

        // Etado de mexico
        $supplier[0]['state_of_mexico']     = $supplier[0]['state_id'];

        // Numero exterior
        $supplier[0]['number_exterior']     = $supplier[0]['number'];

        // Codigo postal
        $supplier[0]['postal_code']         = $supplier[0]['postalcode'];

        // Id de usuario
        $supplier[0]['id']                  = $supplier[0]['id_user'];

        // Seteamos datos al formulario
        $form->setData($supplier[0]);
        
        // Datos enviados a la vista
        $view = array(
            'profile'         => $profile[0],
            'type_profile'    => $profileUser,
            'form'            => $form,
            "pet_type"        => $getCompanyTypePet,
            "sector_activity" => $getCompanySectorActivity,
            "district"        => $supplier[0]['district'],
            "neighborhood"    => $supplier[0]['neighborhood'],
            "notice_company" => $getCompanyNotice
        );

        return new ViewModel($view);
	}

	public function registerAction()
	{
		$layout   = $this->layout();
		$layout->setTemplate('layout/layoutPets');

		$form     = new UsersForm("company_form");

        // Obtenemos lista de typos de mascota
        $getAllTypePet = $this->getTypePetService()->fetchAll();
        //echo "<pre>"; print_r($getAllTypePet); exit;

        // Obtenemos lista de sector de actividad
        $getAllPetActivitySector = $this->getPetActivitySectorService()->fetchAll();
        //echo "<pre>"; print_r($getAllPetActivitySector); exit;

    	$view    = array("form" => $form, "pet_type" => $getAllTypePet, "sector_activity" => $getAllPetActivitySector);
    	$request = $this->getRequest();

    	// Validar el tipo de peticion
    	if ($request->isPost()) {
            
            // Datos recibidos por post
            //$formData = $request->getPost()->toArray();

            $formData = array_merge_recursive(
                $request->getPost()->toArray(),
                $request->getFiles()->toArray()
            );

    		//echo "<pre>"; print_r($formData); exit;

    		// Verificar el correo electronico
    		$verifyEmail = $this->getUsersServices()->verifyEmailExists($formData['email_user']);
    		//echo "<pre>"; print_r($verifyEmail); exit;

    		// Validamos si el correo electronico existe
    		if ($verifyEmail[0]['count'] == 1) {
    			
    			// Respuesta
    			$response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                    "status" => 'fail'
                )));

    		} else if($verifyEmail[0]['count'] == 0) {

    			// Agregamos registro
    			$addUser = $this->getUsersServices()->addUsers($formData);
    			//echo "<pre>"; print_r($addUser); exit;

    			// Respuesta
    			$response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                    "status" => 'ok',
                    "name"  => $formData['name_user']
                )));

    		}

    		// Enviamos respuesta
    		return $response;

    	}

    	return new ViewModel($view);

	}

    public function searchAction()
    {
        $form       = new UsersForm("search_form");
        $view       = array("form" => $form);
        $request    = $this->getRequest();

        if($request->isPost()) {
           
            $formData = $request->getPost()->toArray();
            //echo "<pre>"; print_r($formData); exit;

            $rowsAll = $this->getSupplierService()->fetchAllByFilter($formData);
            //echo "<pre>"; print_r($rowsAll); exit;

            // Respuesta
            $response = $this->getResponse()->setContent(\Zend\Json\Json::encode(array(
                "status"        => 'ok',
                "suppliers"     => $rowsAll
            )));

            return $response;

        }

        return new ViewModel($view);
    }

    public function profileAction()
    {
        $id = (int) $this->params()->fromRoute("id", null);

        // OBTENER PROVEEDOR POR ID
        $supplier                   = $this->getSupplierService()->getSupplierByIdCompany($id);
        //echo "<pre>"; print_r($supplier); exit;

        // Obtenemos lista de tipos de mascotas por id de proveedor
        $getCompanyTypePet          = $this->getCompanyTypePetService()->getCompanyTypePetById($id);
        //echo "<pre>"; print_r($getCompanyTypePet); exit;

        // Obtenemos lista de sector de actividad por id de proveedor
        $getCompanySectorActivity   = $this->getCompanySectorActivityService()->getCompanySectorActivityById($id);

        // Enviamos datos a la vista
        $view    = array(
            "supplier"          => $supplier[0],
            "pet_type"          => $getCompanyTypePet,
            "sector_activity"   => $getCompanySectorActivity
        );
        
        return new ViewModel($view);
    }
}