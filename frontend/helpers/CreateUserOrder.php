<?php

declare(strict_types=1);

namespace frontend\helpers;

use common\models\UserOrder;

class CreateUserOrder
{
    public int $order_id;

    /**
     * @param int $userID
     * @param string $description
     * @param int $totalPrice
     * @return int
     */
    public function createOrder(int $userID, string $description, int $totalPrice): int
    {
        $model = new UserOrder();
        $model->user_id = $userID;
        $model->description = $description;
        $model->total_price = $totalPrice;
        $model->status_id = 1;
        $model->save();
        $this->order_id = $model->order_id;
        return $model->order_id;
    }

    public function returnOrderID(): int
    {
        return $this->order_id;
    }
}
