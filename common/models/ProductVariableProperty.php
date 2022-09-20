<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "product_variable_properties".
 *
 * @property int|null $product_id
 * @property int|null $variable_property_id
 * @property int|null $attribute_id
 * @property PropertyAttribute $attribute0
 * @property Product $product
 * @property VariableProperty $variableProperty
 */
class ProductVariableProperty extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'product_variable_properties';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['product_id', 'variable_property_id', 'attribute_id'], 'default', 'value' => null],
            [['product_id', 'variable_property_id', 'attribute_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['attribute_id'], 'exist', 'skipOnError' => true, 'targetClass' => PropertyAttribute::class, 'targetAttribute' => ['attribute_id' => 'id']],
            [['variable_property_id'], 'exist', 'skipOnError' => true, 'targetClass' => VariableProperty::class, 'targetAttribute' => ['variable_property_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['product_id' => "string", 'variable_property_id' => "string", 'attribute_id' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'product_id' => 'Product ID',
            'variable_property_id' => 'Variable Property ID',
            'attribute_id' => 'Attribute ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getAttribute0(): ActiveQuery
    {
        return $this->hasOne(PropertyAttribute::class, ['id' => 'attribute_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return ActiveQuery
     */
    public function getProduct(): ActiveQuery
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[VariableProperty]].
     *
     * @return ActiveQuery
     */
    public function getVariableProperty(): ActiveQuery
    {
        return $this->hasOne(VariableProperty::class, ['id' => 'variable_property_id']);
    }

    /**
     * @param int $key
     * @param $propertyID
     * @return array
     */
    public static function getListById(int $key, $propertyID): array
    {
        return self::find()->where(['product_id' => $key, 'variable_property_id' => $propertyID])->all();
    }

    /**
     * @param $categoriesIDs
     * @return array
     */
    public static function getAttributesCount($categoriesIDs): array
    {
        $productVariableProperties = ProductVariableProperty::find()->where(['category_id' => $categoriesIDs])->asArray()->all();
        $arr = [];
        foreach ($productVariableProperties as $productVariableProperty) {
            $arr[$productVariableProperty['attribute_id']] = 0;
        }
        foreach ($productVariableProperties as $productVariableProperty) {
            $arr[$productVariableProperty['attribute_id']] += 1;
        }

        return $arr;
    }
}
