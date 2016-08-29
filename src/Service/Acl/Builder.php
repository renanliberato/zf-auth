<?php

namespace Auth\Service\Acl;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * DESCRIPTION
 * PHP Version: 7.0.6
 * Class Builder
 * @package Auth\Service\Acl
 * @author Renan Liberato <renan.libsantana@gmail.com>
 */
class Builder
{
    /**
     * @var array
     */
    private $config;

    /**
     * Builder constructor.
     * @param $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * Constrói a ACL
     * @return Acl 
     */
    public function build()
    {
        $config = $this->config;
        $acl = new Acl();
        foreach ($config['acl']['roles'] as $role => $parent) {
            $acl->addRole(new Role($role), $parent);
        }
        foreach ($config['acl']['resources'] as $r) {
            $acl->addResource(new Resource($r));
        }
        foreach ($config['acl']['privilege'] as $role => $privilege) {
            if (isset($privilege['allow'])) {
                foreach ($privilege['allow'] as $p) {
                    $acl->allow($role, $p);
                }
            }
            if (isset($privilege['deny'])) {
                foreach ($privilege['deny'] as $p) {
                    $acl->deny($role, $p);
                }
            }
        }
        return $acl;
    }
}