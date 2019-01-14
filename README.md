##Test Magento 2

###Requirements

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

###Installation

Is necesary to have docker and docker compose installed.

```
cd /your/project/location
mkdir M2Test
git clone git@github.com:DiegoSana/M2Test.git M2Test
cd M2Test
docker-compose up -d
mysql -uroot -proot -hmysql m2_test < dumps/m2_test.sql
docker exec -it -u www-data apache2 bash
composer install
```

Check your container ip with "docker inspect apache2" and add "{container_ip} m2test.com" to your /etc/hosts file