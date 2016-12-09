<?php

$params = require(__DIR__ . '/params.php');
$mailer = require(__DIR__ . '/mailer.php');

$config = [
    'id' => 'flexap',
    'name' => 'FlexAP',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log'
    ],
    'language'=> 'en',
    'modules' => [
        'user' => [ 
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'User'             => 'app\models\user\User',
                'LoginForm'        => 'app\models\user\LoginForm',
                'RegistrationForm' => 'app\models\user\RegistrationForm',
                'SettingsForm'     => 'app\models\user\SettingsForm',
                'RecoveryForm'     => 'app\models\user\RecoveryForm',
            ],
            'enableConfirmation' => false,
            'admins' => ['admin'],
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule'
    ],
    'components' => [
	'urlManager' => [
	    'enablePrettyUrl' => true,
	    'showScriptName' => false,
            'class' => 'codemix\localeurls\UrlManager',
            'languages' => ['en', 'ru'],
	    'rules' => [
		'' => 'site/index',
		'<controller:[\w\-]+>' => '<controller>/index',
	    ],
	],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'cK_mLtslRMXwcMrw9tkj3vHhJkeAEPY1',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
             'identityClass' => 'app\models\user\User',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@app/views/user'
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => $mailer,
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],     
            ],
        ],
        'authManager' => [
            'class' => 'dektrium\rbac\components\DbManager',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
