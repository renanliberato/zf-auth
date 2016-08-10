<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\View\Helper\Factory;

use Auth\View\Helper\Session;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class SessionFactory
 * @package Auth\View\Helper\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class SessionFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     * @return Session
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $session = $serviceLocator->get('Auth\Session');

        return new Session($session);
    }

}