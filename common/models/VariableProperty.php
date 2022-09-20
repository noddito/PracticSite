<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "variable-property".
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property PropertyAttribute $attribute0
 * @property ProductVariableProperty[] $ProductVariableProperty
 */
class VariableProperty extends ActiveRecord
{
    public array|string $attributesArray = [];
    public array|string $propertyArray = [];

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
        return 'variable_properties';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 240],
            [['attributesArray'], 'safe'],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'name' => "string", 'updated_at' => "string", 'created_at' => "string", 'attributesArray' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'Properties ID'),
            'name' => Yii::t('common', 'Property Name'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
            'attributesArray' => Yii::t('common', 'Attributes'),
        ];
    }

    /**
     * @return array
     */
    public static function getAttributeName(): array
    {
        return PropertyAttribute::find()->select('name')->column();
    }

    /**
     * @return array
     */
    public static function getVariablePropertiesMap(): array
    {
        return VariableProperty::find()->select('name')->indexBy('id')->column();
    }

    /**
     * @return ActiveQuery
     */
    public function getProductVariableProperty(): ActiveQuery
    {
        return $this->hasMany(ProductVariableProperty::class, ['variable_property_id' => 'id']);
    }


    public static function getList($variablePropertyIds): array|null
    {
        if (isset($variablePropertyIds[0])) {
            return self::find()->select(['name'])->where(['id' => $variablePropertyIds])->indexBy('id')->column();
        }

        return null;
    }
}
