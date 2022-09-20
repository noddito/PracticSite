<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_properties".
 * @property integer $properties_id
 * @property integer $product_id
 * @property mixed|string|null $value
 */
class ProductProperty extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'product_properties';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['product_id', 'properties_id'], 'default', 'value' => null],
            [['product_id', 'properties_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['properties_id'], 'exist', 'skipOnError' => true, 'targetClass' => Property::class, 'targetAttribute' => ['Property_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['product_id' => "string", 'properties_id' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'product_id' => 'Product ID',
            'properties_id' => 'Properties ID',
        ];
    }

    /**
     * Gets query for [[Product]].
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[Properties]].
     * @return ActiveQuery
     */
    public function getProperty(): ActiveQuery
    {
        return $this->hasOne(Property::class, ['id' => 'properties_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getProperties(): ActiveQuery
    {
        return $this->hasMany(Property::class, ['id' => 'properties_id']);
    }
}
