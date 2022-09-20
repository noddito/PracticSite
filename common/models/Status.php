<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "status".
 *
 * @property int $id
 * @property string|null $status
 *
 * @property UserOrder[] $userOrders
 * @method static class()
 */
class Status extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'statuses';
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'status' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'status' => Yii::t('backend', 'Status Name'),
        ];
    }

    /**
     * Gets query for [[UserOrders]].
     *
     * @return ActiveQuery
     */
    public function getUserOrders(): ActiveQuery
    {
        return $this->hasMany(UserOrder::class, ['status_id' => 'id']);
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        return self::find()->select(['status'])->indexBy('id')->column();
    }
}
