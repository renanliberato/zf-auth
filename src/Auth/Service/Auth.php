<?php

namespace Auth\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Db\Sql\Select;

class Auth extends Service
{
    private $dbAdapter;

    public function __construct($dbAdapter = null)
    {
        $this->dbAdapter = $dbAdapter;
    }

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

    public function logout()
    {
        $auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Auth\Session');
        $session->offsetUnset('user');
        $auth->clearIdentity();

        return true;
    }

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
