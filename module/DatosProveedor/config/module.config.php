<?php

return array(
    'controllers'=>array(
        'invokables'=>array(
            'DatosProveedor\Controller\Index'=>'DatosProveedor\Controller\IndexController',
         ),
     ),
     
     'router'=>array(
        'routes'=>array(
            'datosProveedor'=>array(
                 'type'=>'Segment',
                    'options'=>array(
                        'route' => '/datosProveedor[/[:action][/:id]]',
                        'constraints' => array(
                                'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                        
                        'defaults'  =>  array(
                                'controller' => 'DatosProveedor\Controller\Index',
                                'action'     => 'index'
                         
                        ),
                    ),
           ),
       ),
    ),
    
   //Cargamos el view manager
   'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'datosProveedor/index/index' => __DIR__ . '/../view/datosProveedor/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
          'datosProveedor' =>  __DIR__ . '/../view',
        ),
    ), 
 );                               