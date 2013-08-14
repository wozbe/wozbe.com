# Intégration Grunt et Bower au sein d'une application Symfony2

## Définition des outils

### Grunt

Développé en Javascript et executé par NodeJS, **[Grunt][grunt]** est utilisé par un large spectre de développeur, et présente de réels atouts par rapport à **Assetic**.  
A première vue, le fait qu'il n'y ai pas d'intégration direct à Symfony2 peut apparaitre comme un désavantage, mais ne pas coupler l'application Symfony2 à la configuration de votre gestionnaire de ressources vous permet une plus grande souplesse.

> Pourquoi utiliser un gestionnaire de tâche ?
> En un mot : L'automatisation. Moins vous avez de travail quand vous executez des tâches répétitives comme la **minification**, la **compilation**, les **tests unitaires**, le **linting**, etc, plus votre travail deviendra simple. Après l'avoir configuré, le gestionnaire de tâche peut faire la plupart du travail trivial pour vous et votre équipe sans aucun effort.

### Bower

Développé et executé aussi par le couple Javascript/NodeJS, **[Bower][bower]** est un gestionnaire de dépendance pour le développement **front-end**.  
Pour faire une comparaison rapide, Bower est l'équivalent de Composer pour les librairies Javascript & CSS.

## Cas d'utilisation, le besoin et la réponse

Chez Wozbe,  
Nous avons pris l'habitude d'utiliser le couple **Bower et Grunt** pour gérer les librairies **front-end** tels que [jQuery][jquery], [YUI][yui], [Bootstrap][bootstrap], [Chosen][chosen], [LESS][less]...

Etant développeur Symfony2,  
Voici le cas d'usage d'une intégration **Bootstrap, jQuery et FontAwesome** au sein d'une application Symfony2 grâce à Bower & Grunt.

### Structure de fichier

Pour commencer,
Nous allons étudier la structure de vos ressources.  

    # Les bundles
    # Standard symfony
    # Contient les sources publiques de votre bundle
    src/Acme/DemoBundle/Resources/public/images
    src/Acme/DemoBundle/Resources/public/js
    src/Acme/DemoBundle/Resources/public/less

    # L'application
    # Non standard symfony
    # Contient les sources publiques de votre application
    app/Resources/public/fonts
    app/Resources/public/images
    app/Resources/public/js
    app/Resources/public/less

#### Les bundles
La structure de vos bundles doit correspondre à la structure **recommandée par Symfony2**. Vous utilisez le répertoire **Resources/public/** pour mettre tout les fichiers qui devront etre disponible par requete HTTP à vos clients.

En tant que développeur Symfony, vous utilisez la commande *app/console assets:install* pour déployer ces fichiers dans le répertoire **web/**.  
Ce déploiement peut-etre réalisé par une copie de fichier ou par la mise en place de lien symbolique avec l'option **--symlink**.

Ce déploiement va donc créer un répertoire **web/bundles/acmedemo/** pour mettre dedans le contenu du répertoire **src/Acme/DemoBundle/Resources/public/**

#### L'application
Pour la structure des ressources de l'application, nous prenons une liberté vis-à-vis du standard Symfony.  
La documentation indique que pour surcharger les templates d'un bundle nous devons utiliser le répertoire **app/Resources/AcmeDemoBundle/views**.  
A ce titre, nous pensons qu'il faut utiliser le répertoire **app/Resources/public** pour gérer les fichiers publics de l'application.

Une de nos tâches Grunt consistera à mettre dans le répertoire **web/bundles/app/** le contenu de **app/Resources/public**, ainsi nous traitons les ressources de l'application comme un bundle.

> Cette structure est contestable sur le fond. Il s'agit d'un essai sur nos projets afin d'en tester l'usage.

### Ce que l'on attends
Nous avons décrit la structure que doivent avoir vos sources. Sur l'utilisation des bundles il n'y a rien de different par rapport à vos habitudes. On change par contre la manière de proceder pour les données communes à votre application.

Voici la structure intermédiaire de vos ressources.

    # Les sources sont copiés dans web/bundles
    # les bundles comme l'application
    web/bundles/acmedemo/images
    web/bundles/acmedemo/js
    web/bundles/acmedemo/less
    web/bundles/app/fonts
    web/bundles/app/images
    web/bundles/app/js
    web/bundles/app/less

Ce que l'on attends pour exploiter le projet, c'est d'avoir different traitement sur les fichiers sources.  
Ces traitements sont : Compilation des fichiers LESS en CSS, minification et/ou obfuscation des sources Javascript.

Notre objectif est de fournir une structure de fichier comme suivant 

    # Les builts sont dans web/built
    # les bundles comme l'application
    web/built/acmedemo/js
    web/built/acmedemo/less
    web/built/app/js
    web/built/app/less

Vous remarquerez que nous n'avons plus les répertoires **images/** et **fonts/**, ces fichiers n'ayant reçu aucune modification.

## Utilisation de Bootstrap avec FontAwesome

## Configuration et Utilisation de Bower

## Configuration et Utilisation de Grunt



Grunt est un outil que l'on peux comparer à [Assetic](http://symfony.com/fr/doc/current/cookbook/assetic/index.html), outil recommandé par Symfony2 pour la gestion des assets.  
Assetic associe des **ressources** et des **filtres** pour presenter des données differente à l'utilisateur, son integration se fait par l'intermédiaire [AsseticBundle](https://github.com/symfony/AsseticBundle).


![Alt text]({{ site.url }}images/logo-wozbe-full-alpha.png)

[jquery]: http://jquery.com/  "jQuery"
[yui]: http://yuilibrary.com/  "YUI"
[bootstrap]: http://getbootstrap.com/  "Twitter Bootstrap"
[chosen]: http://harvesthq.github.io/chosen/  "Chosen"
[less]: http://lesscss.org/  "LESScss"
[grunt]: http://gruntjs.com/  "GruntJS"
[bower]: https://github.com/bower/bower  "Bower"
