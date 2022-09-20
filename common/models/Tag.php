<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 * @property int $id
 * @property string $name
 */
class Tag extends ActiveRecord
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
        return 'tags';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'name' => "string", 'updated_at' => "string", 'created_at' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'Tag ID'),
            'name' => Yii::t('common', 'Tag Name'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTagProduct(): ActiveQuery
    {
        return $this->hasMany(TagProduct::class, ['tag_id' => 'id']);
    }
}
