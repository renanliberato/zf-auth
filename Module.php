<?php

namespace Auth;

use Auth\Service\Auth\AuthListener;
use Zend\Mvc\MvcEvent;

class Module
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
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
}