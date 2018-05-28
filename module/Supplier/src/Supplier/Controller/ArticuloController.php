<?php
namespace Supplier\Controller;

use DatosProveedor\Controller\BaseController;
use DatosProveedor\Services\TypePetService;
use Supplier\Form\ArticuloForm;
use Zend\View\Model\ViewModel;

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

        $form = new ArticuloForm("form");
        $view = array("form" => $form);
        
        if($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            if($form->isValid()){
                
                //Cargamos el modelo
                $tipoArticulo=new TypePetService();
                
                //Recogemos los datos del formulario
                $articulo = $this->request->getPost("articulo");
                
                //                 print_r($sector); exit;
                //Insertamos en la bd
                $insert=$tipoArticulo->addArticulo($articulo);
                
                //Mensajes flash $this->flashMessenger()->addMenssage("mensaje");
                if($insert==true){
                    
                    $this->flashMessenger()->setNamespace("add_correcto")->addMessage("Articulo añadido correctamente");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/articulo/');
                    
                }else{
                    
                    $this->flashMessenger()->setNamespace("duplicado")->addMessage("Articulo duplicado mete otro");
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
        
        $tipoArticuloService=new TypePetService();
        
        $articuloSelect=$tipoArticuloService->getArticulo($id);
//         "<pre>"; print_r($articuloSelect); exit;
        $form=new ArticuloForm("form");
        $form->setData($articuloSelect);
        
//         print_r($form);exit;
        $vista=array("form"=>$form);
        
        if($this->getRequest()->isPost()) {
            
            $form->setData($this->getRequest()->getPost());
            
            if($form->isValid()){
                
                $articulo=$this->request->getPost("articulo");
                
                //Insertamos en la bd
                $update=$tipoArticuloService->updateArticulo($id, $articulo);
                
                if($update==true){
                    
                    $this->flashMessenger()->setNamespace("add_correcto")->addMessage("Articulo modificado correctamente");
                    return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/articulo/');
                    
                }else{
                    
                    $this->flashMessenger()->setNamespace("duplicado")->addMessage("El Articulo se ha modificado");
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
        $tipoArticuloService=new TypePetService();
        
        $delete=$tipoArticuloService->deletebyId($id);
        
        if($delete==true){
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("Articulo eliminado correctamente");
        }else{
            $this->flashMessenger()->setNamespace("eliminado")->addMessage("El articulo no a podido ser eliminado");
        }
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/articulo/');
    }
}

