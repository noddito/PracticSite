<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag_product".
 * @property integer $tag_id
 * @property integer $product_id
 */
class TagProduct extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'tag_products';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['product_id', 'tag_id'], 'default', 'value' => null],
            [['product_id', 'tag_id'], 'integer'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::class, 'targetAttribute' => ['tag_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['product_id' => "string", 'tag_id' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'product_id' => 'Product ID',
            'tag_id' => 'Tag ID',
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
     * Gets query for [[Tag]].
     * @return ActiveQuery
     */
    public function getTag(): ActiveQuery
    {
        return $this->hasOne(Tag::class, ['id' => 'tag_id']);
    }
}
