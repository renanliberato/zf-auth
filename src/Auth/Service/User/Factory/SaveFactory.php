<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\User\Factory;

use Auth\Service\User\Save;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class SaveFactory
 * @package Auth\Service\User\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class SaveFactory implements FactoryInterface
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

        return new Save($dbAdapter);
    }
}