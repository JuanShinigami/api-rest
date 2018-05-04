<?php

namespace Supplier;

return array(
	'controllers' => array(
 		'invokables' => array(
			'Supplier\Controller\Index' => 'Supplier\Controller\IndexController',
		),
	),

	'router' => array(
         'routes' => array(
             'supplier' => array(
                 'type' => 'literal',
                 'options' => array(
                     'route'    => '/supplier',
                     'defaults' => array(
                         'controller' => 'Supplier\Controller\Index',
                         'action'     => 'index',
                     ),
                 ),
                 'may_terminate' => true,
                 'child_routes'  => array(
                     'detail' => array(
                         'type' => 'segment',
                         'options' => array(
                             'route'    => '[/:action][/:id]',
                             'defaults' => array(
                             	'controller' => 'Supplier\Controller\Index',
                            	'action' => 'index'
                             ),
                             'constraints' => array(
                            	'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     => '[a-zA-Z0-9][a-zA-Z0-9_-]*',
                             )
                         )
                     )
                 )
             )
         )
	),



	'view_manager' => array(
		/*'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layoutAuth.phtml',
        ),*/
		'template_path_stack' => array(
			'supplier' => __DIR__ . '/../view',
		),
	),
 );