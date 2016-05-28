<?php

namespace Auth\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;

class Auth implements ServiceManagerAwareInterface
{
    /**
     * Auth database adapter.
     * 
     * @var \Zend\Db\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * Allow Auth class to work with services.
     * 
     * @var ServiceManager
     */
    protected $serviceManager;

    /**
     * Initialize Auth database adapter.
     * 
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct($dbAdapter = null)
    {
        $this->dbAdapter = $dbAdapter;
    }

    /**
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        //return $this;
    }

    /**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * Authenticate the user in the database and
     * add user information to the Session
     * 
     * @param $params
     * @return bool
     */
    public function authenticate($params)
    {
        //to change
        $password = md5($params['password']);
        
        $auth = new AuthenticationService();

        $authAdapter = new AuthAdapter($this->dbAdapter);
        $authAdapter
            ->setTableName('user')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password')
            ->setIdentity($params['email'])
            ->setCredential($password);
            
        $result = $auth->authenticate($authAdapter);
        
        if(!$result->isValid()){
            return false;
        }

        $session = $this->getServiceManager()->get('Auth\Session');
        $session->offsetSet('user', $authAdapter->getResultRowObject(null,array('password')));

        return true;
    }

    /**
     * Destroy session user information.
     * 
     * @return bool
     */
    public function logout()
    {
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Auth\Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();

        return true;
    }

    /**
     * Method responsible to authorize the user using the route and session information.
     * 
     * @param $controllerName
     * @param $actionName
     * @return bool
     */
    public function authorize($controllerName, $actionName)
    {
        $auth = new AuthenticationService();
        $role = 'guest';
        if ($auth->hasIdentity()) {
            $session = $this->getServiceManager()->get('Auth\Session');
            $user = $session->offsetGet('user');
            $role = $user->role;
        }

        $resource = $controllerName . '.' . $actionName;
        $acl = $this->getServiceManager()->get('Core\Acl\Builder')->build();
        if ($acl->isAllowed($role, $resource)) {
            return true;
        }
        return false;
    }
}
