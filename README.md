[![Wozbe](http://wozbe.com/bundles/app/images/logo-wozbe-full-alpha.png)](http://wozbe.com)
=====

[![Build Status](https://api.travis-ci.org/wozbe/wozbe.com.png)](http://travis-ci.org/#!/wozbe/wozbe.com)

Requirement
-----------
To develop you need NodeJS & NPM on your system.

Also, [bower](https://github.com/bower/bower) & [grunt](http://gruntjs.com/) are required.

    # See grunt "Getting Started" : http://gruntjs.com/getting-started#installing-the-cli
    sudo npm install -g grunt-cli
    sudo npm install -g bower

    # Install all NodeJS dependency
    sudo npm install

Translations
------------
Extract translations using JMS

    php app/console translation:extract en --config=app
    php app/console translation:extract fr --config=app

Update translations using JMS WebUI : **http://wozbe.local/_trans/**

Assets
------
Global assets are manage inside **app/Resource/public**

Global views are manage inside **app/Resource/views**

Using [glyphicons](http://glyphicons.com/) & [font-awesome](http://fortawesome.github.io/Font-Awesome/icons/)

Deploy assets
-------------
Download client dependencies
    
    bower install

Symlink assets from bundles & application to web/

    php app/console assets:install && grunt assets:install

Make a first pass to compile assets

    grunt

Files are compiled on web/built/[bundle]/[type]/

Easy development

    grunt watch

Production deployment
---------------------
<<<<<<< HEAD

To deploy you need capifony which can be installed with **gem** ruby tool `$ gem install capifony`
=======
Simply use capifony 
>>>>>>> vagrant

    cap production deploy

This will do all the deployment jobs : clone repository, install dependencies, compiled assets ...


Vagrant
-------
This application is runnable using vagrant

Local requirements

* Vagrant
* VirtualBox
* Internet connection

Configure the vagrant environment.

```bash
$ git submodule init
$ git submodule update
$ cp vagrant/config.yml.dist vagrant/config.yml
$ vim vagrant/config.yml # Choose private IP
$ vagrant up
```

Now VM is running, install latest requirement fixtures

```bash
$ vagrant ssh
$ cd /vagrant
$ app/console doctrine:database:create
$ app/console doctrine:schema:update --force
$ app/console wozbe:install -d
```

Because we use /dev/shm instead of NFS folder to store symfony logs and caches,
Fix permissions.

```bash
$ sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX /dev/shm/symfony/
$ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx /dev/shm/symfony/
```

License
-------

This bundle is under the MIT license. [See the complete license](https://github.com/wozbe/wozbe.com/blob/master/LICENSE).
