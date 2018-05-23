<?php

return array(
    'controllers'=>array(
        'invokables'=>array(
            'Supplier\Controller\Index'=>'Supplier\Controller\IndexController',
            'Supplier\Controller\Crud'=>'Supplier\Controller\CrudController',
            'Supplier\Controller\Articulo'=>'Supplier\Controller\ArticuloController',
        ),
    ),
    
    'router'=>array(
        'routes'=>array(
            'supplier'=>array(
                'type'=>'Segment',
                'options'=>array(
                    'route' => '/supplier[/[:action][/:id]]',
                    'constraints' => array(
                        'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    
                    'defaults'  =>  array(
                        'controller' => 'Supplier\Controller\Index',
                        'action'     => 'index'
                        
                    ),
                ),
            ),
            
            //Nueva ruta para el nuevo controlador
            'crud'=>array(
                'type'=>'Segment',
                'options'=>array(
                    'route' => '/crud[/[:action][/:id]]',
                    'constraints' => array(
                        'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'  =>  array(
                        'controller' => 'Supplier\Controller\Crud',
                        'action'     => 'index'
                        
                    ),
                ),
            ),
            
            //Nueva ruta para el nuevo controlador
            'articulo'=>array(
                'type'=>'Segment',
                'options'=>array(
                    'route' => '/articulo[/[:action][/:id]]',
                    'constraints' => array(
                        'action'  =>  '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults'  =>  array(
                        'controller' => 'Supplier\Controller\Articulo',
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
            'supplier/index/index' => __DIR__ . '/../view/supplier/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'supplier' =>  __DIR__ . '/../view',
        ),
    ),
);                               