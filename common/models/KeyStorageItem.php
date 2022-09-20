<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "key_storage_item".
 * @property integer $key
 * @property integer $value
 */
class KeyStorageItem extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return '{{%key_storage_item}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['key', 'value'], 'required'],
            [['key'], 'string', 'max' => 128],
            [['value', 'comment'], 'safe'],
            [['key'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    #[ArrayShape(['key' => "string", 'value' => "string", 'comment' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'key' => Yii::t('common', 'Key'),
            'value' => Yii::t('common', 'Value'),
            'comment' => Yii::t('common', 'Comment'),
        ];
    }
}
