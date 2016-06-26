<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

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
     * @return mixed
     */
    public function fetchAll($where = array(), $order = 'id ASC')
    {
        $select = new Select();

        $select->from(User::TABLE);

        $select->where($where);

        $select->order($order);

        $resultSet = $this->tableGateway->selectWith($select);

        return $resultSet;

    }
    
    

}