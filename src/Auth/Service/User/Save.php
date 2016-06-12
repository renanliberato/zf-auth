<?php
/**
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */

namespace Auth\Service\User;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class Save
 * @package Auth\Service\User
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class Save
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
    
    public function insert()
    {
        
    }
    
    public function update()
    {
        
    }
}