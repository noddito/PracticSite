<?php

declare(strict_types=1);

namespace frontend\helpers;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Yii;


class SendOrder implements iPost
{
    public const SHOP_EMAIL = 'MyShop@kit.ru';
    public const TOPIC = 'Заказ товаров с сайта MySite.com №';
    public const SMS_MESSAGE = 'Ваш заказ принят в работу, номер заказа №';
    public string $email;

    /**
     * @param $data
     * @param string $userAddress
     * @param int $orderID
     * @return void
     */
    public function sendEmail($data, string $userAddress, int $orderID): void
    {
        Yii::$app->mailer->compose()
            ->setFrom(self::SHOP_EMAIL)
            ->setTo($userAddress)
            ->setSubject(self::TOPIC . $orderID)
            ->setHtmlBody($data)
            ->send();
        $log = new Logger('SendOrder');
        $log->pushHandler(new StreamHandler('../../common/runtime/logs/logs.log', Logger::INFO));
        $log->info((' Заказ №' . $orderID . ' от ' . $userAddress));
    }

    public function sendSMS(int $orderID, int $userNumber): void
    {
        $result = (Yii::$app->sms->sendSms($userNumber, self::SMS_MESSAGE . $orderID, true, 1, 1));
        Yii::error($result);
    }
}
