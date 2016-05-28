<?php

namespace Auth\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;
use Auth\Form\Login;

class AuthController extends AbstractActionController
{
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
        $service = $this->getServiceLocator()->get('Auth\Service\Auth');
        $auth = $service->authenticate(
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
        $service = $this->getServiceLocator()->get('Auth\Service\Auth');
        $service->logout();

        return $this->redirect()->toUrl('/');
    }
}