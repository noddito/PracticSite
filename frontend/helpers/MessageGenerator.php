<?php

declare(strict_types=1);

namespace frontend\helpers;

use common\models\Product;

class MessageGenerator
{
    public string $message = '<table class="order-table">';
    public int $totalCount = 0;

    /**
     * @param $data
     * @return string
     */
    public function createMessage($data): string
    {
        $productPrices = Product::find()->select(['price'])->indexBy('id')->asArray()->column();
        $productList = Product::find()->select(['name'])->indexBy('id')->asArray()->column();

        $this->message .= '<th>Продукт</th>';
        $this->message .= '<th>Количество</th>';
        $this->message .= '<th>Цена</th>';
        foreach ($data['count'] as $key => $count) {
            $product = $productList[$key] ?? null;
            if ($product !== null) {
                $this->message .= '<tr>';
                $this->message .= '<td>' . $product . '</td> <td>' . $count . 'шт. </td>' . '</td> <td>' . ((int)$productPrices[$key]) * (int)$count . 'руб. </td>';
                $this->message .= '</tr>';
                self::fillTotalCount(((int)$productPrices[$key]), (int)$count);
            }
        }
        $this->message .= '<tr>';
        $this->message .= '<th> Итого:' . $this->totalCount . ' руб.</th>';
        $this->message .= '</tr>';
        $this->message .= '</table>';

        return $this->message;
    }

    /**
     * @param int|float $productPrice
     * @param int|float $productCount
     * @return int|float
     */
    public function fillTotalCount(int|float $productPrice, int|float $productCount): int|float
    {
        $this->totalCount += $productPrice * $productCount;
        return $this->totalCount;
    }

    /**
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
