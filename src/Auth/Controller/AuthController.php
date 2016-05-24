<?php

namespace Auth\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Auth\Form\Login;

class AuthController extends ActionController
{
    public function indexAction()
    {
        $form = new Login();
        return new ViewModel(array(
            'form' => $form
        ));
    }

    public function errorAction()
    {
        return new ViewModel();
    }

    public function loginAction()
    {
        $request = $this->getRequest();
        
        if(!$request->isPost()) {
            $this->flashMessenger()->addErrorMessage('Acesso inválido');
            
            return $this->redirect()->toUrl('/auth/auth');
        }

        $data = $request->getPost();
        $service = $this->getService('Auth\Service\Auth');
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

    public function logoutAction()
    {
        $service = $this->getService('Auth\Service\Auth');
        $service->logout();

        return $this->redirect()->toUrl('/');
    }
}