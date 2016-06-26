<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 28/05/16
 * Time: 12:06
 */

namespace Auth\Controller;

use Auth\Model\UserTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

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
     * @var UserTable
     */
    protected $tableGateway;

    /**
     * UserController constructor.
     * 
     * @param UserTable $tableGateway
     */
    public function __construct(UserTable $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @return JsonModel
     */
    public function indexAction()
    {
        return new JsonModel($this->tableGateway->fetchAll());
    }

    /**
     * @return JsonModel
     */
    public function newAction()
    {
        if (!$this->getRequest()->isPost()) {

            return new JsonModel(array(
                'status'   => 'error',
                'messages' => array(
                    'Acesso inválido'
                ),
            ));
        }

        $data = $this->getRequest()->getPost();

        return new JsonModel($this->tableGateway->insert($data));
    }
}
