<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Controller\Factory;

use Auth\Controller\AuthController;
use Auth\Service\Auth\Auth;
use Zend\ServiceManager\FactoryInterface;
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
     * Create service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $authenticator = $serviceLocator->getServiceLocator()->get(Auth::class);

        return new AuthController($authenticator);
    }
}