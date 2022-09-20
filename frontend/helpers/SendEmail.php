<?php

declare(strict_types=1);

namespace frontend\helpers;

use Yii;

class SendEmail
{
    /**
     * @param $data
     * @param string $userAddress
     * @return void
     */
    public static function sendMessage($data, string $userAddress): void
    {
        Yii::$app->mailer->compose()
            ->setFrom($userAddress)
            ->setTo($data['recipient'])
            ->setSubject($data['topic'])
            ->setTextBody($data['text'])
            ->send();
    }
}
