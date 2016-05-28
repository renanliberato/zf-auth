<?php

namespace Auth\Controller;

use Zend\View\Model\ViewModel;
use Zend\Mvc\Controller\AbstractActionController;

/**
 * Controlador que gerencia os posts
 * 
 * @category Skel
 * @package Controller
 * @author  Elton Minetto<eminetto@coderockr.com>
 */
class IndexController extends AbstractActionController
{
    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {
        return new ViewModel();
    }
}