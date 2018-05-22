<?php
namespace DatosProveedor\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use DatosProveedor\Controller\BaseController;
// use Application\Services\TypePetService;
// use Application\Services\PetActivitySectorService;
// use Users\Form\UsersForm;
// use Users\Service\UsersService;
use Supplier\Service\SupplierService;
use Supplier\Service\CompanyTypePetService;
use Supplier\Service\CompanySectorActivityService;

class IndexController extends BaseController

// extends AbstractActionController
{
	
	public function indexAction()
	{
	    
	    print_r("nuevo modulo");exit;
        return new ViewModel($view);
	}
	
}