The storage extension for Yii2.
===============================
This extension provides support for multi storage.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist yiizh/yii2-storage "dev-master"
```

or add

```
"yiizh/yii2-storage": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Change config file :

```php
...
    'components' => [
        'storage' => [
            'class'=>'\yiizh\storage\LocalStorage',
            'basePath' => '@app/web/uploads'
        ]
    ]
...
```