<?php

namespace backend\helpers;

use Yii;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;
use yii\httpclient\Exception;

class UsdCourse
{
    private const REQUEST_URL = 'https://www.cbr-xml-daily.ru/daily_json.js';

    /**
     * @return float
     * @throws Exception
     * @throws InvalidConfigException
     */
    public static function getUsdCourse(): float
    {
        $cache = Yii::$app->cache;
        $key = 'usd_course';
        $usd_course = $cache->get($key);
        if ($usd_course === false) {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl(self::REQUEST_URL)
                ->send();
            if ($response->isOk) {
                $usd_course = $response->data;

                return $usd_course['Valute']['USD']['Value'];
            }
            $cache->set($key, false, 3600);
        }

        return $usd_course;
    }
}
