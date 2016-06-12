<?php

namespace Auth\Controller;

use Auth\Service\Auth\Auth as Authenticator;
use Auth\Form\Login;
use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class AuthController
 * @package Auth\Controller
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class AuthController extends AbstractActionController
{
    /**
     * @var Authenticator
     */
    protected $authenticator;

    /**
     * AuthController constructor.
     *
     * @param Authenticator $authService
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
    }

    /**
     * Method responsible to render login page.
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        $form = new Login();

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * View rendered when a user try to access a not authorized page.
     *
     * @return ViewModel
     */
    public function errorAction()
    {
        return new ViewModel();
    }

    /**
     * Authenticate the user and redirect to the main page.
     *
     * @return \Zend\Http\Response
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        
        if(!$request->isPost()) {
            $this->flashMessenger()->addErrorMessage('Acesso inválido');
            
            return $this->redirect()->toUrl('/auth/auth');
        }

        $data = $request->getPost();
        $auth = $this->authenticator->authenticate(
            array(
                'email' => $data['email'],
                'password' => $data['password'],
            )
        );
        
        if(!$auth) {
            $this->flashMessenger()->addErrorMessage('Usuário ou senha errados!');

            return $this->redirect()->toUrl('/auth/auth');
        }

        return  $this->redirect()->toUrl('/');
    }

    /**
     * Logout the user and redirect to the main page.
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->authenticator->logout();

        return $this->redirect()->toUrl('/');
    }
}