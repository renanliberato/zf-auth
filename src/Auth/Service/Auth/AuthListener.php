<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Event;

use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class AuthListener
 * @package Auth\Event
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class AuthListener
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = array();

    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * AuthListener constructor.
     * @param Authenticator $authenticator
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

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
     * @param $e
     * @return bool
     */
    public function mvcPreDispatch($e)
    {
        $routeMatch     = $e->getRouteMatch();
        $moduleName     = $routeMatch->getParam('module');
        $controllerName = $routeMatch->getParam('controller');
        $actionName     = $routeMatch->getParam('action');

        $authenticator = $e->getServiceLocator()->get('Auth\Service\Auth');

        if (!$this->authenticator->authorize($controllerName, $actionName)) {

            $controller = $event->getTarget();
            $controller->flashMessenger()->addErrorMessage('Acesso não autorizado');

            return $controller->redirect()->toUrl('/application/index/index');
        }

        return true;
    }
}