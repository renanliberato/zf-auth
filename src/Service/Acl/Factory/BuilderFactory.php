<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Acl\Factory;

use Auth\Service\Acl\Builder;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class BuilderFactory
 * @package Auth\Service\Acl\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class BuilderFactory implements FactoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');

        return new Builder($config);
    }

}