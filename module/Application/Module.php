<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $serviceManager = $e->getApplication()->getServiceManager();
        $dbAdapter      = $serviceManager->get('Zend\Db\Adapter\Adapter');
        \Zend\Db\TableGateway\Feature\GlobalAdapterFeature::setStaticAdapter($dbAdapter);
      
        
        //Iniciamos la lista de control de acceso
//         $this->initAcl($e);
        
        //Comprobamos la lista de control de acceso
//         $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
//     //Este método se ejecuta cada vez que carga una página
//     public function onBootstrap(MvcEvent $e){
//         //Iniciamos la lista de control de acceso
//         $this->initAcl($e);
        
//         //Comprobamos la lista de control de acceso
//         $e->getApplication()->getEventManager()->attach('route', array($this, 'checkAcl'));
//     }

    public function getDbRoles(MvcEvent $e){
        // I take it that your adapter is already configured
        $dbAdapter = $e->getApplication()->getServiceManager()->get('Zend\Db\Adapter\Adapter');
        $results = $dbAdapter->query('SELECT perfil FROM perfil');
        // making the roles array
        print_r("Entro    ");
        print_r($results);exit;
        
        $roles = array();
        foreach($results as $result){
            $roles[$result['user_role']][] = $result['resource'];
        }
        return $roles;
    }
    
    public function initAcl(MvcEvent $e){
        //Creamos el objeto ACL
        $acl = new \Zend\Permissions\Acl\Acl();
        
        //Incluimos la lista de roles y permisos, nos devuelve un array
//         $roles=require_once 'config/autoload/acl.roles.php';
// this
//         $roles = include __DIR__ . '/config/module.acl.roles.php';
        // with
        $roles = $this->getDbRoles($e);
        
        foreach($roles as $role => $resources){
            
            //Indicamos que el rol será genérico
            $role = new \Zend\Permissions\Acl\Role\GenericRole($role);
            
            //Añadimos el rol al ACL
            $acl->addRole($role);
            
            //Recorremos los recursos o rutas permitidas
            foreach($resources["allow"] as $resource){
                
                
                //Si el recurso no existe lo añadimos
                if(!$acl->hasResource($resource)){
                    $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                }
                
                
                //Permitimos a ese rol ese recurso
                $acl->allow($role, $resource);
            }
            
            foreach ($resources["deny"] as $resource) {
                
                //Si el recurso no existe lo añadimos
                if(!$acl->hasResource($resource)){
                    $acl->addResource(new \Zend\Permissions\Acl\Resource\GenericResource($resource));
                }
                
                //Denegamos a ese rol ese recurso
                $acl->deny($role, $resource);
            }
            
            
            //pruebas
//             var_dump ($ acl-> isAllowed ('admin', 'home'));
            //cierto
            
        }
        
        //Establecemos la lista de control de acceso
        $e->getViewModel()->acl=$acl;
    }
    
    public function checkAcl(MvcEvent $e){
        //guardamos el nombre de la ruta o recurso a permitir o denegar
        $route=$e->getRouteMatch()->getMatchedRouteName();
        
        //Instanciamos el servicio de autenticacion
        $auth=new \Zend\Authentication\AuthenticationService();
        $identi=$auth->getStorage()->read();
        
        // Establecemos nuestro rol
        $userRole ="application";
        
        // Si el usuario esta identificado le asignaremos el rol admin y si no el rol visitante.
        if($identi!=false && $identi!=null){
            $userRole="application";
        }
        else{
           // $userRole="voluntario";
        }
        /*
         Esto se puede mejorar fácilmente, si tenemos un campo rol en la BD cuando el usuario
         se identifique en la sesión se guardarán todos los datos del mismo, de modo que
         $userRole=$identi->role;
         */
        
        //Comprobamos si no está permitido para ese rol esa ruta
        if(!$e->getViewModel()->acl->isAllowed($userRole, $route)) {
            
            //Devolvemos un error 404
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $e->getRequest()->getBaseUrl() . '/404');
            $response->setStatusCode(404);
        }
        
    }


}
