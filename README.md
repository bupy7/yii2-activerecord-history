yii2-activerecord-history
=========================

[![Latest Stable Version](https://poser.pugx.org/bupy7/yii2-activerecord-history/v/stable)](https://packagist.org/packages/bupy7/yii2-activerecord-history)
[![Total Downloads](https://poser.pugx.org/bupy7/yii2-activerecord-history/downloads)](https://packagist.org/packages/bupy7/yii2-activerecord-history)
[![Latest Unstable Version](https://poser.pugx.org/bupy7/yii2-activerecord-history/v/unstable)](https://packagist.org/packages/bupy7/yii2-activerecord-history)
[![License](https://poser.pugx.org/bupy7/yii2-activerecord-history/license)](https://packagist.org/packages/bupy7/yii2-activerecord-history)
[![Build Status](https://travis-ci.org/bupy7/yii2-activerecord-history.svg?branch=master)](https://travis-ci.org/bupy7/yii2-activerecord-history)
[![Coverage Status](https://coveralls.io/repos/github/bupy7/yii2-activerecord-history/badge.svg?branch=master)](https://coveralls.io/github/bupy7/yii2-activerecord-history?branch=master)

This extension adds storage history of changes to the ActiveRecord model.

Extension can tacking changes to model and save to storage.
Allowed only storage to database. All changes saved to table in database.

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

> NOTICE! Configuration of module must have in `common/config/main.php` if you will use `andanced` template. Or add configuration in both `config/web.php` and `config/console.php` if you will use `basic` template.

**Register of module to config file:**

```php
'modules' => [
    'arhistory' => [
        'class' => 'bupy7\activerecord\history\Module',
    ],
],
```

Name of module can be any (example: history, custom-name and etc).

**Add module in bootstrap to config file:**

```php
'bootstrap' => ['arhistory'],
```

**Run migration:**

```php
php ./yii migrate/up --migrationPath=@bupy7/activerecord/history/migrations
```

**Attach behavior to model:**

```php
use bupy7\activerecord\history\behaviors\History as HistoryBehavior;

$model->attachBehavior('arHistory', HistoryBehavior::className());
```

Configuration
-------------

**Module configuration:**

```php
'modules' => [
    'arhistory' => [
        'class' => 'bupy7\activerecord\history\Module',
        'tableName' => '{{%arhistory}}', // table name of saving changes of model
        'storage' => 'bupy7\activerecord\history\storages\Database', // class name of storage for saving history of active record model
        'db' => 'db', // database connection component config or name
        'user' => 'user', // authentication component config or name
    ],
],
```

**Behavior configuration:**

```php
use bupy7\activerecord\history\behaviors\History as HistoryBehavior;

$model->attachBehavior('arHistory', [
    'class' => HistoryBehavior::className(),
    // allowed events list than are monitored and saved in storage.
    'allowEvents' => [
        HistoryBehavior::EVENT_INSERT,
        HistoryBehavior::EVENT_UPDATE,
        HistoryBehavior::EVENT_DELETE,
    ],
    // list of attributes which not need track at updating. Apply only for `HistoryBehavior::EVENT_UPDATE`.
    'skipAttributes' => [
        'name_of_attribute_1',
        'name_of_attribute_2',
    ],
    // list of custom attributes which which are a pair of `key`=>`value` where `key` is attribute name and
    // `value` it anonymous callback function of attribute. Function will be apply for old and value information data.
    // Apply only for `HistoryBehavior::EVENT_UPDATE`.
    'customAttributes' => [
        'name_of_attribute_3' => function($event, $isNewValue) {
            if ($isNewValue) {
                return $event->sender->name_of_attribute_3; 
            }
            return $event->changedAttributes['name_of_attribute_3'];
        },
    ],
]);
```

License
-------

yii2-activerecord-history is released under the BSD 3-Clause License.
