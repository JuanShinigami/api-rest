<?php
namespace Supplier\Controller;

use DatosProveedor\Controller\BaseController;
use DatosProveedor\Services\PetActivitySectorService;
use Supplier\Form\SectorForm;
use Zend\View\Model\ViewModel;


class CrudController extends BaseController

{

    function indexAction()
    {
        $sectorActivityService = new PetActivitySectorService();
        $sectorActivity = $sectorActivityService->fetchAll();
        
        $view = array(
            "sectorActivity" => $sectorActivity
        );
        
        return new ViewModel($view);
    }
    
    function addAction(){
        
        $form = new SectorForm("form");
        $view = array("form" => $form);
        
        if($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()){
                
                //Cargamos el modelo
                $setActivitySector=new PetActivitySectorService();
                
                //Recogemos los datos del formulario
                $sector = $this->request->getPost("sector");
                
//                 print_r($sector); exit;
                //Insertamos en la bd
                $insert=$setActivitySector->addSector($sector);
                
                //Mensajes flash $this->flashMessenger()->addMenssage("mensaje");
                if($insert==true){
                    
                    $this->flashMessenger()->setNamespace("add_correcto")->addMessage("Sector añadido correctamente");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/crud/');
                    
                }else{
                    
                    $this->flashMessenger()->setNamespace("duplicado")->addMessage("Sector duplicado mete otro");
                    return $this->redirect()->refresh();
                    
                }
                
            }else{
                
                $err=$form->getMessages();
                $vista=array("form"=>$form,'url'=>$this->getRequest()->getBaseUrl(),"error"=>$err);
                
            }
        }
        return new ViewModel($view); 
    }
    
    function modificarAction(){
        $id=$this->params()->fromRoute("id",null);
        
        $petActivitySectorService=new PetActivitySectorService();
        $sectorSelect=$petActivitySectorService->getSector($id);
        
        $form=new SectorForm("form");
        $form->setData($sectorSelect);
        
        
        $vista=array("form"=>$form);
        
        if($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            
            if($form->isValid()){
                
                $sector=$this->request->getPost("sector");
                
                //Insertamos en la bd
                $update=$petActivitySectorService->updateSector($id,$sector);
                
                if($update==true){
                    
                    $this->flashMessenger()->setNamespace("add_correcto")->addMessage("Sector modificado correctamente");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/crud/');
                    
                }else{
                    
                    $this->flashMessenger()->setNamespace("duplicado")->addMessage("El Sector se ha modificado");
                    return $this->redirect()->refresh();
                    
                }
                
            }else{
                
                $err=$form->getMessages();
                $vista=array("form"=>$form,'url'=>$this->getRequest()->getBaseUrl(),"error"=>$err);
                
            }
            
        }
        
        return new ViewModel($vista); 
    }
    
    function eliminarAction(){
        
        $id=$this->params()->fromRoute("id",null);
        $sectorActivityService=new PetActivitySectorService();
        
        $delete=$sectorActivityService->deletebyId($id);
        
        if($delete==true){
            
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("Sector eliminado correctamente");
            
        }else{
            
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("El Sector no a podido ser eliminado");
            
        }
        
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/crud/');
    }
}

