<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\TableGateway;

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
    const MODEL = 'Auth\Model\User';

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

    public function fetchAll($where = null, $order = null)
    {
        $select = new Select();

        $select->from(self::MODEL);

        if($where)
            $select->where($where);

        if($order)
            $select->order($order);

        $fetchAll = $this->tableGateway->selectWith($select);
        var_dump($fetchAll);
        return $fetchAll;

    }
    
    

}