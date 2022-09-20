<?php
$config = [
    'homeUrl' => Yii::getAlias('@frontendUrl'),
    'controllerNamespace' => 'frontend\controllers',
    'bootstrap' => ['maintenance'],
    'defaultRoute' => 'site/index',
    'modules' => [
        'user' => [
            'class' => frontend\modules\user\Module::class,
            'shouldBeActivated' => false,
            'enableLoginByPass' => false,
        ],
    ],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error'
        ],
        'sms' => [
            'class' => 'y0zh\sms\Sms',
            'cascade' => true,
            'services' => [
                // http://iqsms.ru/api/api_rest/
                'iqsmsc_ru' => [
                    'class' => 'y0zh\sms\services\IqmscRuService',
                    'login' => '...',
                    'password' => '...',
                    'order' => 2,
                ],
                // http://iqsms.ru/api/api_rest/
                'iqsmsc_ru_2' => [
                    'class' => 'y0zh\sms\services\IqmscRuService',
                    'login' => '...',
                    'password' => '...',
                    'order' => 3,
                ],
                // http://smsc.ru/api/
                'smsc_ru' => [
                    'class' => 'y0zh\sms\services\SmscRuService',
                    'login' => '...',
                    'password' => '...',
                    'order' => 1
                ],
            ]
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'cookieValidationKey' => env('FRONTEND_COOKIE_VALIDATION_KEY')
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ]
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'messageCategory' => 'frontend'
            ]
        ]
    ];
}

return $config;
