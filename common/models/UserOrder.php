<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_order".
 *
 * @property int $order_id
 * @property int|null $user_id
 * @property int|null $status_id;
 * @property string|null $description
 * @property float|null $total_price
 * @property User $user
 * @method static class()
 */
class UserOrder extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'user_orders';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'default', 'value' => null],
            [['status_id'], 'default', 'value' => 1],
            [['user_id'], 'integer'],
            [['description'], 'string'],
            [['total_price'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['order_id' => "string", 'status_id' => "string", 'user_id' => "string", 'description' => "string", 'total_price' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'order_id' => Yii::t('common', 'Order ID'),
            'status_id' => Yii::t('common', 'Status'),
            'user_id' => Yii::t('common', 'User Name'),
            'description' => Yii::t('common', 'Description'),
            'total_price' => Yii::t('common', 'Total Price'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStatus(): ActiveQuery
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }

    /**
     * @return array
     */
    public static function getUserMap(): array
    {
        return User::find()->select('username')->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public static function getStatusMap(): array
    {
        return Status::find()->select('status')->indexBy('id')->column();
    }
}
