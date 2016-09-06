<?php

namespace Auth;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'controllers' => array( //add module controllers
        'factories' => array(
            'Auth\Controller\Auth' => Controller\Factory\AuthControllerFactory::class,
        ),
    ),
    'db' => array(
        'adapters' => array(
            'authAdapter' => array(
                'driver'         => 'Pdo',
                'dsn'            => 'mysql:dbname=UserDB;host=172.17.0.2',
                'driver_options' => array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                ),
            ),
        )
    ),
    'service_manager' => array(
        'factories' => array(
            \Zend\Db\Adapter\Adapter::class => \Zend\Db\Adapter\AdapterServiceFactory::class,
            Service\Auth\Auth::class        => Service\Auth\Factory\AuthFactory::class,
            Service\Acl\Builder::class      => Service\Acl\Factory\BuilderFactory::class,
            'Auth\Session'                  => Service\Session\Factory\SessionFactory::class,
            
        ),
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'authSession' => 'Auth\View\Helper\Session',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/auth[/:action]',
                    'defaults' => [
                        'controller'    => 'Auth\Controller\Auth',
                        'action'        => 'index',
                    ],
                ],
            ],
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
            'Auth\Controller\User.index',
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
);