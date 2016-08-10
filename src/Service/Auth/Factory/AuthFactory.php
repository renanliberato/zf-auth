<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Auth\Factory;

use Auth\Service\Auth\Auth;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class AuthFactory
 * @package Auth\Service\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class AuthFactory implements FactoryInterface
{

    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     * @return Auth
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dbAdapter = $container->get('authAdapter');
        $session   = $container->get('Auth\Session');
        $builder   = $container->get('Auth\Service\Acl\Builder');

        return new Auth($dbAdapter, $session, $builder);
    }
}