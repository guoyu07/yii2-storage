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

### Config

#### For local storage

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

#### For Aliyun storage

```php
...
    'components' => [
        'storage' => [
            'class' => '\yiizh\storage\AliyunStorage',
            'accessKey' => '<您从OSS获得的AccessKeyId>',
            'accessSecret' => '<您从OSS获得的AccessKeySecret>',
            'endpoint' => '<您选定的OSS数据中心访问域名，例如oss-cn-hangzhou.aliyuncs.com>',
            'bucket' => '<您的绑定在某个Bucket上的自定义域名>',
        ]
    ]
...
```

### Upload File

```
\Yii::$app->storage->save('文件名', '文件内容');
```