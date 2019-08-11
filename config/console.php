<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$container = require  __DIR__ . '/container.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'queue'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'container' => $container,
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'queue' => [
//            'class' => \yii\queue\amqp_interop\Queue::class,
//            'host' => 'localhost',
//            'port' => 15672,
//            'user' => 'guest',
//            'password' => 'guest',
//            'queueName' => 'queue',
//            'driver' => yii\queue\amqp_interop\Queue::ENQUEUE_AMQP_LIB,
//            'as log' => \yii\queue\LogBehavior::class
//        ],

        'queue' => [
            'class' => \yii\queue\file\Queue::class,
            'as log' => \yii\queue\LogBehavior::class
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
