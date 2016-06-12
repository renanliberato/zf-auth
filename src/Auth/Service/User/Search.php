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

    public function fetchAll($columns = null, $where = null, $order = null)
    {
        $model = new User();
        $tableGateway = new TableGateway('\Auth\Model\User', $this->dbAdapter);

        $select = new Select();
        if ($columns)
            $select->columns($columns);
        $select->from('Auth\Model\User');
        if($where)
            $select->where($where);
        if($order)
            $select->order($order);

        $fetchAll = $tableGateway->selectWith($select);
        $model->setData($fetchAll);

        return $model->getData();
    }
}