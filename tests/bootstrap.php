<?php

// ensure we get report on all possible php errors
error_reporting(-1);

define('YII_ENABLE_ERROR_HANDLER', false);
define('YII_DEBUG', true);

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = [
    'id' => 'test',
    'basePath' => __DIR__,
    'components' => [
        'request' => [
            'scriptUrl' => __FILE__,
        ],
    ],
];
new \yii\web\Application($config);
