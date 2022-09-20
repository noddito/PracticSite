<?php

declare(strict_types=1);

namespace app\models;

use common\models\Product;
use Yii;
use yii\base\Model;

class Basket extends Model
{
    /**
     * @param int $id
     * @param int $count
     * @return void
     */
    public function addToBasket(int $id, int $count = 1): void
    {
        if ($count < 1) {
            return;
        }
        $id = abs($id);
        $product = Product::findOne($id);
        if (empty($product)) {
            return;
        }
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('basket')) {
            $session->set('basket', []);
            $basket = [];
        } else {
            $basket = $session->get('basket');
        }
        if (isset($basket['products'][$product->id])) {
            $count = $basket['products'][$product->id]['count'] + $count;
            if ($count > 100) {
                $count = 100;
            }
        } else {
            $basket['products'][$product->id]['name'] = $product->name;
            $basket['products'][$product->id]['price'] = $product->price;
        }
        $basket['products'][$product->id]['count'] = $count;
        $amount = 0.0;
        foreach ($basket['products'] as $item) {
            $amount = $amount + $item['price'] * $item['count'];
        }
        $basket['amount'] = $amount;
        $session->set('basket', $basket);
    }

    /**
     * @param int $id
     * @return int
     */
    public static function returnCountByID(int $id): int
    {
        $count = 0;
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('basket')) {
            $session->set('basket', []);
            $basket = [];
        } else {
            $basket = $session->get('basket');
        }
        if (!empty($basket)) {
            foreach ($basket['products'] as $product) {
                if ($id === key($basket['products'])) {
                    $count = $product['count'];
                }
                next($basket['products']);
            }
        }

        return $count;
    }

    /**
     * @param int $id
     * @return void
     */
    public function removeFromBasket(int $id): void
    {
        $id = abs((int)$id);
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('basket')) {
            return;
        }
        $basket = $session->get('basket');
        if (!isset($basket['products'][$id])) {
            return;
        }
        unset($basket['products'][$id]);
        if (count($basket['products']) == 0) {
            $session->set('basket', []);

            return;
        }
        $amount = 0.0;
        foreach ($basket['products'] as $item) {
            $amount = $amount + $item['price'] * $item['count'];
        }
        $basket['amount'] = $amount;

        $session->set('basket', $basket);
    }

    /**
     * @return mixed
     */
    public function getBasket(): mixed
    {
        $session = Yii::$app->session;
        $session->open();
        if (!$session->has('basket')) {
            $session->set('basket', []);

            return [];
        } else {
            return $session->get('basket');
        }
    }

    /**
     * @return void
     */
    public function clearBasket(): void
    {
        $session = Yii::$app->session;
        $session->open();
        $session->set('basket', []);
    }

    /**
     * @param $data
     * @return void
     */
    public function updateBasket($data): void
    {
        $this->clearBasket();
        foreach ($data['count'] as $id => $count) {
            $this->addToBasket($id, (int)$count);
        }
    }
}
