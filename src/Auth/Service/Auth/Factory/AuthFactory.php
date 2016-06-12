<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Auth\Factory;

use Auth\Service\Auth\Auth;
use Zend\ServiceManager\FactoryInterface;
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
     * Create service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $dbAdapter = $serviceLocator->get('dbAuth');
        $session   = $serviceLocator->get('Auth\Session');
        $builder   = $serviceLocator->get('Auth\Service\Acl\Builder');

        return new Auth($dbAdapter, $session, $builder);
    }
}