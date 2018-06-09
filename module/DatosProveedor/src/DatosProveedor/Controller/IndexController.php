<?php
namespace DatosProveedor\Controller;


class IndexController extends BaseController

// extends AbstractActionController
{
	
	public function indexAction()
	{
	    
	    $layout    = $this->layout(); // Indicamos layout
	    $layout->setTemplate('layout/layoutPets');
	    $request    = $this->getRequest();
	}
	
}