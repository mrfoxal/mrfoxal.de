<?php

return [
    'basePath' => dirname(__DIR__),
    'name' => 'mrfoxal',
    'language' => 'de-DE',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\user\User',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_a:(login|logout|signup|request-password-reset|reset-password|search)>' => 'site/<_a>',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/update/<id:\d+>' => '<_c>/update',
                '<_c:[\w\-]+>/delete/<id:\d+>' => '<_c>/delete',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
                // tags
                'tag/search' => 'tag/search',
                [
                    'class' => 'app\components\PostUrlRule',
                ]
            ],
            'baseUrl' => 'https://mrfoxal.de',
        ],
        'formatter' => [
            'dateFormat' => 'dd.MM.yyyy',
            'locale' => 'de-DE'
        ],
    ],
];
