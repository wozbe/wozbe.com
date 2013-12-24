Wozbe
=====

[![Wozbe](http://wozbe.com/bundles/app/images/logo-wozbe-full-alpha.png)](http://wozbe.com)

[![Build Status](https://api.travis-ci.org/wozbe/wozbe.com.png)](http://travis-ci.org/#!/wozbe/wozbe.com)

Requirement
-----------
To develop you need NodeJS, NPM & PHP on your system.

Also, [bower](https://github.com/bower/bower), [grunt](http://gruntjs.com/) & [composer](http://getcomposer.org/)are required.

    sudo npm install -g grunt-cli # See grunt "Getting Started" : http://gruntjs.com/getting-started#installing-the-cli
    sudo npm install -g bower
    curl -sS https://getcomposer.org/installer | php
    

    # Install all NodeJS dependencies
    sudo npm install
    
    # Install all client dependencies
    bower install
    
    # Install all PHP dependencies
    composer install --dev --no-interaction

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
Symlink assets from bundles & application to web/

    php app/console assets:install --symlink --relative && grunt assets:install

Make a first pass to compile assets

    grunt

Files are compiled on web/built/[bundle]/[type]/

Easy development

    grunt watch

Production deployment
---------------------

To deploy you need capifony which can be installed with **gem** ruby tool `$ gem install capifony`

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

Now VM is running and configured. You could create an entry inside the `/etc/hosts` file to bind **wozbe.dev** to this VM.

```bash
$ open http://wozbe.dev
```

License
-------

This bundle is under the MIT license. [See the complete license](https://github.com/wozbe/wozbe.com/blob/master/LICENSE).
