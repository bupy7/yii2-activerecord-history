yii2-activerecord-history
=========================
This extension adds storage history of changes to the ActiveRecord model.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bupy7/yii2-activerecord-history "*"
```

or add

```
"bupy7/yii2-activerecord-history": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
<?= \bupy7\activerecord\history\AutoloadExample::widget(); ?>```