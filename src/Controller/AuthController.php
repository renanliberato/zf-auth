<?php

namespace Auth\Controller;

use Auth\Form\Login;
use Auth\Model\User;
use Auth\Service\Auth\Auth as Authenticator;
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
     * @var Login
     */
    protected $form;

    /**
     * @var User
     */
    protected $model;

    /**
     * AuthController constructor.
     *
     * @param Authenticator $authService
     */
    public function __construct(Authenticator $authenticator)
    {
        $this->authenticator = $authenticator;
        $this->form          = new Login();
        $this->model         = new User();
    }

    /**
     * Method responsible to render login page.
     * 
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'form' => $this->form
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
        throw new \Exception('teste', 300);
        $request = $this->getRequest();
        
        if(!$request->isPost()) {
            $this->flashMessenger()->addErrorMessage('Acesso inválido');
            
            return $this->redirect()->toUrl('/auth/auth');
        }

        $data = $request->getPost();
        unset($data['submit']);
        $this->form->setData($data);

        if ($this->form->isValid()) {
            $validData = $this->form->getData();

            $auth = $this->authenticator->authenticate(
                array(
                    'email'    => $validData['email'],
                    'password' => $validData['password'],
                )
            );

            if(!$auth) {
                $this->flashMessenger()->addErrorMessage('Usuário ou senha errados!');

                return $this->redirect()->toUrl('/auth');
            }
            $this->flashMessenger()->addSuccessMessage('Login efetuado com sucesso!');
            return  $this->redirect()->toUrl('/auth');
        }
        $this->flashMessenger()->addErrorMessage('Usuário ou senha errados!');

        return $this->redirect()->toUrl('/auth');
    }

    /**
     * Logout the user and redirect to the main page.
     *
     * @return \Zend\Http\Response
     */
    public function logoutAction()
    {
        $this->authenticator->logout();

        return $this->redirect()->toUrl('/auth');
    }
}