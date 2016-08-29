<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Controller\Factory;

use Auth\Controller\AuthController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible to instantiate AuthController with its dependency: Auth service.
 *
 * PHP Version: 7.0.6
 * Class AuthControllerFactory
 * @package Auth\Controller\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class AuthControllerFactory implements FactoryInterface
{
    /**
    * Create an object
    *
    * @param  ContainerInterface $container
    * @param  string             $requestedName
    * @param  null|array         $options
    * @return object
    * @throws ServiceNotFoundException if unable to resolve the service.
    * @throws ServiceNotCreatedException if an exception is raised when
    *     creating a service.
    * @throws ContainerException if any other error occurs
    */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authenticator = $container->get('Auth\Service\Auth\Auth');

        return new AuthController($authenticator);
    }
}