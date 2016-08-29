<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Acl\Factory;

use Auth\Service\Acl\Builder;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
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
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        return new Builder($config);
    }

}