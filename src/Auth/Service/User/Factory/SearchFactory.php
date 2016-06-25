<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\User\Factory;

use Auth\Service\User\Search;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class SearchFactory
 * @package Auth\Service\User\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class SearchFactory implements FactoryInterface
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
        $dbAdapter = $serviceLocator->get('authAdapter');

        return new Search($dbAdapter);
    }
}