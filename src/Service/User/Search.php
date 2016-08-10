<?php
/**
 * Created by PhpStorm.
 * User: renan
 * Date: 29/05/16
 * Time: 00:05
 */

namespace Auth\Service\User;

use Auth\Model\User;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class Search
{
    const MODEL = 'Auth\Model\User';

    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $dbAdapter;

    /**
     * Initialize Auth database adapter.
     *
     * @param \Zend\Db\Adapter\Adapter $dbAdapter
     */
    public function __construct($dbAdapter = null)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll($where = null, $order = null)
    {
        $model = new User();
        $tableGateway = new TableGateway(self::MODEL, $this->dbAdapter);

        $select = new Select();

        $select->columns($this->columns);

        $select->from(self::MODEL);

        if($where)
            $select->where($where);

        if($order)
            $select->order($order);

        $fetchAll = $tableGateway->selectWith($select);

        $model->setData($fetchAll);

        return $model->getData();
    }
}