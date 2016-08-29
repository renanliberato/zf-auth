<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Session\Factory;

use Interop\Container\ContainerInterface;
use Zend\Session\Container;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class SessionFactory
 * @package Auth\Service\Session\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class SessionFactory implements FactoryInterface
{
    const CONTAINER_NAME = 'Auth';

    /**
     * {@inheritDoc}
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new Container(self::CONTAINER_NAME);
    }

}