<?php

namespace Auth\Service\Auth;

use Auth\Service\Acl\Builder;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Crypt\Password\Bcrypt;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Session\Container;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class Auth
 * @package Auth\Service\Auth
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class Auth
{
    /**
     * Auth database adapter.
     * 
     * @var \Zend\Db\Adapter\Adapter
     */
    private $dbAdapter;

    /**
     * @var Container
     */
    private $session;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * Auth constructor.
     * @param Adapter $dbAdapter
     * @param Container $session
     * @param Builder $builder
     */
    public function __construct(Adapter $dbAdapter, Container $session, Builder $builder)
    {
        $this->dbAdapter = $dbAdapter;
        $this->session   = $session;
        $this->builder   = $builder;
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
        $tablegateway = new TableGateway('user', $this->dbAdapter);

        $resultSet = $tablegateway->select(array('email' => $params['email']));

        if ($resultSet == 0) {
            return false;
        }

        $bcrypt      = new Bcrypt();
        $auth        = new AuthenticationService();
        $authAdapter = new AuthAdapter($this->dbAdapter);


        $searchedUser = $resultSet->current();
        $check        = $bcrypt->verify($params['password'], $searchedUser['password']);
        if (!$check) {
            return false;
        }

        $authAdapter
            ->setTableName('user')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password')
            ->setIdentity($searchedUser['email'])
            ->setCredential($searchedUser['password']);
            
        $result = $auth->authenticate($authAdapter);

        if(!$result->isValid()){
            return false;
        }

        $this->session->offsetSet('user', $authAdapter->getResultRowObject(null,array('password')));

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
        $this->session->offsetUnset('user');
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
            $user = $this->session->offsetGet('user');
            $role = $user->role;
        }

        $resource = $controllerName . '.' . $actionName;
        $acl = $this->builder->build();
        if ($acl->isAllowed($role, $resource)) {
            return true;
        }
        return false;
    }
}
