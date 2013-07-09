[![Wozbe](http://wozbe.com/bundles/app/images/logo-wozbe-full-alpha.png)](http://wozbe.com)
=====

[![Build Status](https://api.travis-ci.org/wozbe/wozbe.com.png)](http://travis-ci.org/#!/wozbe/wozbe.com)

Requirement
-----------
To develop you need NodeJS & NPM on your system.

Also, [bower](https://github.com/bower/bower) & [grunt](http://gruntjs.com/) are required.

    # See grunt "Getting Started" : http://gruntjs.com/getting-started#installing-the-cli
    sudo npm install -g grunt-cli

    # Install all NodeJS dependency
    sudo npm install

To deploy you need capifony

    cap production deploy

Assets
------
Global assets are manage inside **app/Resource/public**

Global views are manage inside **app/Resource/views**

Using [glyphicons](http://glyphicons.com/) & [font-awesome](http://fortawesome.github.io/Font-Awesome/icons/)

Deploy assets
-------------
Symlink assets from bundles & application to web/

    php app/console assets:install --symlink && grunt symlink

Make a first pass to compile assets

    grunt

Files are compiled on web/built/[bundle]/[type]/

Easy development

    grunt watch

Production deployment
---------------------

Simply use capifony 

    cap production deploy

This will do all the deployment jobs : clone repository, install dependencies, compiled assets ...

License
-------

This bundle is under the MIT license. [See the complete license](https://github.com/wozbe/wozbe.com/blob/master/LICENSE).