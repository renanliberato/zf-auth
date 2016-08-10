<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Controller\Factory;

use Auth\Controller\UserController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Factory responsible to instantiate UserController with its dependency: Auth\Service\User\Search.
 *
 * PHP Version: 7.0.6
 * Class UserControllerFactory
 * @package Auth\Controller\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class UserControllerFactory implements FactoryInterface
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
        $searcher = $serviceLocator->getServiceLocator()->get('Auth\Service\User\Search');

        return new UserController($searcher);
    }
}