<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\Auth\Factory;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class AuthListenerFactory
 * @package Auth\Service\Auth\Factory
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class AuthListenerFactory
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedEvents      = $events->getSharedManager();
        $this->listeners[] = $sharedEvents->attach(
            'Zend\Mvc\Controller\AbstractActionController',
            MvcEvent::EVENT_DISPATCH,
            array($this, 'mvcPreDispatch'),
            100
        );
    }

    /**
     * {@inheritDoc}
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param MvcEvent $e
     * @return bool
     */
    public function mvcPreDispatch($e)
    {
        $routeMatch     = $e->getRouteMatch();
        $moduleName     = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName     = $routeMatch->getParam('action');

        $authenticator = $e->getApplication()->getServiceManager()->get('Auth\Service\Auth\Auth');

        if (!$authenticator->authorize($controllerName, $actionName)) {

            $controller = $e->getTarget();
            $controller->flashMessenger()->addErrorMessage('Acesso não autorizado');

            return $controller->redirect()->toUrl('/application/index/index');
        }

        return true;
    }
}