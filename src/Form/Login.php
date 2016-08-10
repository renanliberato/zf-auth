<?php

namespace Auth\Form;

use Zend\Form\Form;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class Login
 * @package Auth\Form
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class Login extends Form
{
    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action','/auth/auth/login');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'class' => 'form-control',
                'placeholder' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'class' => 'form-control',
                'placeholder' => 'Password'
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Entrar',
                'id' => 'submitbutton',
                'class' => 'form-control',
            ),
        ));

    }
}