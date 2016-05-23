<?php

return array(
    'controllers' => array( //add module controllers
        'invokables' => array(
            'Auth\Controller\Index' => 'Auth\Controller\IndexController',
            'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Session' => function($sm) {
                return new Zend\Session\Container('Schoolcandy');
            },
            'Auth\Service\Auth' => function($sm) {
                $dbAdapter = $sm->get('dbUsers');
                return new Auth\Service\Auth($dbAdapter);
            },
        ),
    ),

    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Auth\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                        'module'        => 'auth'
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                        'child_routes' => array( //permite mandar dados pela url 
                            'wildcard' => array(
                                'type' => 'Wildcard'
                            ),
                        ),
                    ),
                    
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'auth' => __DIR__ . '/../view',
        ),
    ),
    'acl' => array(
        'roles' => array(
            'guest' => null,
            'user'  => 'guest',
        ),
        'resources' => array(
            'Auth\Controller\Auth.index',
            'Auth\Controller\Auth.login',
            'Auth\Controller\Auth.logout',
        ),
        'privilege' => array(
            'guest' => array(
                'allow' => array(
                    'Auth\Controller\Auth.index',
                    'Auth\Controller\Auth.login',
                    'Auth\Controller\Auth.logout',
                ),
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'dbUsers' => array(
                'driver' => 'Pdo',
                'dsn' => 'mysql:dbname=auth;host=localhost',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),
        ),
    ),
);