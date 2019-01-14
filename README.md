## Test Magento 2

### Requirements

**CMS Banner**
 
Create a Magento 2 module from scratch to show a single banner on the frontend. You also need to set up a Docker environment from scratch in order to run your Magento 2 installation and your module.

Magento 2 module requirements:

The user needs to be able to enable/disable the banner in the admin

The user needs to be able to use the WYSIWYG editor to provide the HTML to be used on the banner

Database table requirements:


Your module must have an installer that creates a database table called ‘banners’

Docker requirements:


Apache - MySQL - PHP 7

Bonus

Magento 2:

The more complex features from Magento 2 you use more points you are going to earn. Example: the usage of Interfaces, Proxies, Factories, and so on.



Docker:
You can also set up more containers such as Redis, ElasticSearch, Varnish, and so on.

### Installation

Is necesary to have docker and docker compose installed.

```
cd /your/project/location
mkdir M2Test
git clone git@github.com:DiegoSana/M2Test.git M2Test
cd M2Test
docker-compose up -d
#### Get mysql container ip with "docker inspect mysql"
mysql -uroot -proot -h{mysql_ip} m2_test < dumps/m2_test.sql
docker exec -it -u www-data apache2 bash
composer install
```

Make sure that app/etc/env.php have this content

```
<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'crypt' => [
        'key' => '48139733e2c4329f36f862aef5a62d9a'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'database_server',
                'dbname' => 'm2_test',
                'username' => 'root',
                'password' => 'root',
                'model' => 'mysql4',
                'engine' => 'innodb',
                'initStatements' => 'SET NAMES utf8;',
                'active' => '1'
            ]
        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'developer',
    'session' => [
        'save' => 'files'
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'compiled_config' => 1
    ],
    'install' => [
        'date' => 'Sat, 12 Jan 2019 22:04:16 +0000'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'database' => '0',
                    'port' => '6379'
                ]
            ],
            'page_cache' => [
                'backend' => 'Cm_Cache_Backend_Redis',
                'backend_options' => [
                    'server' => 'redis',
                    'database' => '1',
                    'port' => '6379',
                    'compress_data' => '0'
                ]
            ]
        ]
    ]
];
```

Check your container ip with "docker inspect apache2" and add "{container_ip} m2test.com" to your /etc/hosts file

- Url: http://m2test.com/
- Admin Url: http://m2test.com/admin/
- Admin Usr: admin
- Admin Psw: admin123