<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 28/05/16
 * Time: 12:06
 */

namespace Auth\Controller;

use Auth\Service\User\Search as Searcher;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class UserController
 * @package Auth\Controller
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class UserController extends AbstractActionController
{
    /**
     * @var Searcher
     */
    protected $searcher;

    /**
     * UserController constructor.
     * 
     * @param Searcher $searcher
     */
    public function __construct(Searcher $searcher)
    {
        $this->searcher = $searcher;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel();
    }

    /**
     * @return ViewModel
     */
    public function newAction()
    {
        return new ViewModel();
    }
}