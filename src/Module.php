<?php

namespace Auth;

use Auth\Service\Auth\AuthListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getTarget()->getEventManager();

        $authListener = new AuthListener();
        $authListener->attach($eventManager);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}