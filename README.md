npk.of.by
=========


About
-----

Repo for http://npk.of.by.

Author: Alexander Chaika <manti.by@gmail.com>

Requirements: Apache 2.2.10, PHP 5.2.17, MySQL 5.5.59


Installation
-------------

1. Install [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)

2. Build LAMP from Docker file

        $ docker build -t mantiby/apache-php-5-2 .
        
3. Run instances
        
        $ docker-compose up

4. Open browser at [localhost:8080](http://localhost:8080) and enjoy

