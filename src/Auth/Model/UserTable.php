<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\InputFilter\InputFilterInterface;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class UserTable
 * @package Auth\Service\TableGateway
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class UserTable
{
    /**
     * @var TableGateway
     */
    protected $tableGateway;

    /**
     * UserTableFactory constructor.
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param array $where
     * @param string $order
     * @return PlainObject
     */
    public function fetchAll($where = array(), $order = 'id ASC')
    {
        $select = new Select();

        $select->from(User::TABLE);

        $select->where($where);

        $select->order($order);

        try {
            $resultSet = $this->tableGateway->selectWith($select);

            $fetchAll = array();
            foreach ($resultSet as $result) {
                $fetchAll[] = $result->getData();
            }

            return array(
                'status'   => 'success',
                'content'  => $fetchAll,
                'messages' => 'Ação realizada com sucesso'
            );

        } catch (\Exception $exc) {

            return array(
                'status'   => 'error',
                'messages' => array(
                    'Não foi possível realizar a ação desejada'
                )
            );

        }
    }

    /**
     * @param array $data
     * @return PlainObject
     */
    public function insert($data = array())
    {
        $filter = (new User())->getInputFilter();

        $isValid = $filter->setData($data)
                          ->setValidationGroup(InputFilterInterface::VALIDATE_ALL)
                          ->isValid();

        if (!$isValid) {
            return array(
                'status'   => 'error',
                'messages' => $filter->getMessages()
            );

        }

        try {
            $this->tableGateway->insert($data);

            return array(
                'status' => 'success',
            );

        } catch (\Exception $exc) {
            return array(
                'status'   => 'error',
                'messages' => array(
                    'Não foi possível realizar a ação desejada'
                )
            );
        }
    }
    

}