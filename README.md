# zf2-auth

##Description
<p>This is an Authentication module create on top of Zend Framework 2.</p>
<p>It's objective is to integrate all configuration dependencies inside the module, not needing to do aditional configurations inside global.php or Application's module.config.</p>

##External Resources
###[Bootstrap 3](http://getbootstrap.com/getting-started/#download)

##How to install

- git clone https://github.com/renanliberato/zf2-auth.git

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