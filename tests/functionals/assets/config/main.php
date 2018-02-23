<?php

use bupy7\activerecord\history\tests\Env;

$env = Env::getInstance();

return [
    'id' => 'app-test',
    'basePath' => __DIR__ . '/..',
    'vendorPath' => __DIR__ . '/../../../../vendor',
    'aliases' => [
        '@bupy7/activerecord/history' => __DIR__ . '/../../../../src',
    ],
    'bootstrap' => ['arhistory'],
    'modules' => [
        'arhistory' => [
            'class' => 'bupy7\activerecord\history\Module',
        ],
    ],
    'components' => [
        'request' => [
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'wefJDF8sfdsfSDefwqdxj9oq',
            'scriptFile' => __DIR__ . '/index.php',
            'scriptUrl' => '/index.php',
        ],
        'assetManager' => [
            'basePath' => '@app/assets',
            'baseUrl' => '/',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => sprintf('mysql:host=%s;dbname=%s', $env->getDbHost(), $env->getDbName()),
            'username' => $env->getDbUsername(),
            'password' => $env->getDbPassword(),
            'charset' => 'utf8',
        ],
        'user' => [
            'identityClass' => 'bupy7\activerecord\history\tests\functionals\assets\models\User',
        ],
    ],
];
