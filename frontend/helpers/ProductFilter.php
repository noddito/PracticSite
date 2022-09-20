<?php

declare(strict_types=1);

namespace frontend\helpers;

use common\models\ProductVariableProperty;
use Yii;
use yii\db\ActiveQuery;

class ProductFilter
{
    /**
     * @param $categoryID
     * @return ActiveQuery
     */
    public function getFilter($categoryID): ActiveQuery
    {
        $query = ProductVariableProperty::find()->with('product', 'category');
        foreach (Yii::$app->request->get() as $key => $attribute_id) {
            if ($key !== 'page' && $key !== 'per-page' && !is_string($attribute_id)) {
                $query->orFilterWhere(['variable_property_id' => $key, 'attribute_id' => (int)$attribute_id[0]]);
                if (count($attribute_id) > 1) {
                    foreach ($attribute_id as $item) {
                        $query->orFilterWhere(['variable_property_id' => $key, 'attribute_id' => (int)$item]);
                    }
                }
            }
        }
        if ($categoryID !== null) {
            $query->andWhere(['category_id' => $categoryID]);
        }

        return $query;
    }
}
