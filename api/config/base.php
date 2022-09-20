<?php
return [
    'id' => 'api',
    'basePath' => dirname(__DIR__),
    'components' => [
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
        'urlManager' => require(__DIR__ . '/_urlManager.php'),
        'cache' => require(__DIR__ . '/_cache.php'),
    ],
];
