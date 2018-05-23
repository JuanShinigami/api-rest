<?php
namespace Supplier\Controller;

use DatosProveedor\Controller\BaseController;
use DatosProveedor\Services\PetActivitySectorService;
use Zend\View\Model\ViewModel;
use DatosProveedor\Services\TypePetService;

class ArticuloController extends BaseController

{
    
    function indexAction()
    {
        $tipoArticuloService = new TypePetService();
        $tipoArticulo= $tipoArticuloService->fetchAll();
        // print_r($sectorActivity); exit;
        
        $view = array(
            "tipoArticulo" => $tipoArticulo
        );
        
        return new ViewModel($view);
    }
    
    function addAction(){
        echo"add";exit;
    }
    
    function modificarAction(){
        echo"modificar";exit;
    }
    
    function eliminarAction(){
        $id=$this->params()->fromRoute("id",null);
        $sectorActivityService=new PetActivitySectorService();
        
        $delete=$sectorActivityService->deletebyId($id);
        
        if($delete==true){
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("Usuario eliminado correctamente");
        }else{
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("El usuario no a podido ser eliminado");
        }
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/crud/');
    }
}

