<?php

return array(
    'controllers' => array( //add module controllers
        'factories' => array(
            'Auth\Controller\Auth' => Auth\Controller\Factory\AuthControllerFactory::class,
            'Auth\Controller\User' => 'Auth\Controller\Factory\UserControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            Auth\Model\UserTable::class     => Auth\Model\Factory\UserTableFactory::class,
            Auth\Service\Acl\Builder::class => Auth\Service\Acl\Factory\BuilderFactory::class,
            Auth\Service\Auth\Auth::class   => Auth\Service\Auth\Factory\AuthFactory::class,
            Auth\Service\User\Save::class   => Auth\Service\User\Factory\SaveFactory::class,
            Auth\Service\User\Search::class => Auth\Service\User\Factory\SearchFactory::class,
            'Auth\Session'                  => Auth\Service\Session\Factory\SessionFactory::class,
            'Zend\Db\Adapter\Adapter'       => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
        'abstract_factories' => array(
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'authSession' => Auth\View\Helper\Session::class,
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
            'Auth\Controller\User.index',
            'Auth\Controller\User.new',
        ),
        'privilege' => array(
            'guest' => array(
                'allow' => array(
                    'Auth\Controller\Auth.index',
                    'Auth\Controller\Auth.login',
                    'Auth\Controller\Auth.logout',
                ),
            ),
            'user' => array(
                'allow' => array(
                    'Auth\Controller\User.index',
                    'Auth\Controller\User.new',
                ),
            ),
        ),
    ),
    'db' => array(
        'adapters' => array(
            'authAdapter' => array(
                'driver'  => 'Pdo',
                'dsn'     => 'mysql:dbname=auth;host=localhost',
                'driver_options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
                ),
            ),
        ),
    ),
);