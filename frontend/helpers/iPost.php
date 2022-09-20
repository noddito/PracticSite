<?php

declare(strict_types=1);

namespace frontend\helpers;

interface iPost
{
    /**
     * @param $data
     * @param string $userAddress
     * @param int $orderID
     * @return void
     */
    public function sendEmail($data, string $userAddress, int $orderID): void;

    /**
     * @param int $orderID
     * @param int $userNumber
     * @return void
     */
    public function sendSMS(int $orderID, int $userNumber): void;
}
