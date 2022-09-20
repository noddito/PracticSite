<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "property_attributes".
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property ProductVariableProperty[] $ProductVariableProperty
 * @property VariableProperty[] $variableProperty
 */
class PropertyAttribute extends ActiveRecord
{
    /**
     * @return string[]
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class
        ];
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'property_attributes';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at', 'property_id'], 'integer'],
            [['name'], 'string', 'max' => 240],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'name' => "string", 'property_id' => "string", 'updated_at' => "string", 'created_at' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'Attribute ID'),
            'name' => Yii::t('common', 'Attribute Name'),
            'property_id' => Yii::t('common', 'Property ID'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * Gets query for [[ProductVariableProperty]].
     *
     * @return ActiveQuery
     */
    public function getProductVariableProperty(): ActiveQuery
    {
        return $this->hasMany(ProductVariableProperty::class, ['attribute_id' => 'id']);
    }

    /**
     * Gets query for [[VariableProperty]].
     *
     * @return ActiveQuery
     */
    public function getVariableProperties(): ActiveQuery
    {
        return $this->hasMany(VariableProperty::class, ['attribute_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getPropertyAttribute(): ActiveQuery
    {
        return $this->hasOne(PropertyAttribute::class, ['id' => 'attribute_id']);
    }

    /**
     * @return array
     */
    public static function getAttributesMap(): array
    {
        return PropertyAttribute::find()->select('name')->indexBy('id')->column();
    }

    /**
     * @param $variablePropertyIds
     * @return array
     */
    public static function getListById($variablePropertyIds): array|null
    {
        if (isset($variablePropertyIds[0])) {
            return self::find()->where(['property_id' => $variablePropertyIds])->indexBy('id')->all();
        }

        return null;
    }

    /**
     * @param int $key
     * @return array
     */
    public static function getListByAttributeId(int $key): array
    {
        return self::find()->select(['name'])->where(['id' => $key])->column();
    }
}
