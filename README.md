# zf2-auth

##Description
<p>This is an Authentication module create on top of Zend Framework 2.</p>
<p>It's objective is to integrate all configuration dependencies inside the module, not needing to do aditional configurations inside global.php or Application's module.config.</p>

##External Resources
###[Bootstrap 3](http://getbootstrap.com/getting-started/#download)

### Additionals Zend Framework Components
 - zend-db
 - zend-permissions-acl
 - zend-crypt

##How to install

- `git clone https://github.com/renanliberato/zf2-auth.git`

###global.php
Implementation to use more than one database.
```php
'service_manager' => array(
    'factories' => array(
        'Zend\Db\Adapter\Adapter'
                => 'Zend\Db\Adapter\AdapterServiceFactory',
    ),
    'abstract_factories' => array(
        'Zend\Db\Adapter\AdapterAbstractServiceFactory',
    ),
),
```

##Components

###Auth\Controller\AuthController

###Auth\Service\Auth


###Partials

####Login/Logout navbar-right partial
`<?=$this->partial('partials/navbar/auth.phtml')?>`