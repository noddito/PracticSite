<?php

declare(strict_types=1);

namespace app\models;

use common\models\User;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;

class ResetPassword extends ActiveRecord
{
    public const SHOP_EMAIL = 'MyShop@kit.ru';
    public const TOPIC = 'Восстановление пароля';
    public const LINK = '';

    public string|null $password = null;

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            [['password'], 'required']
        ];
    }

    /**
     * @return string[]
     */
    #[ArrayShape(['password' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'password' => 'Пароль'
        ];
    }

    /**
     * @param string $email
     * @throws Exception
     */
    public function createSecretKey(string $email): void
    {
        $user = User::findOne(['email' => $email]);
        $user->secret_key = Yii::$app->security->generateRandomString() . '_' . time();
        $user->is_valid_until = Time() + 600;
        $user->save();
        self::sendResetLetter($email);
    }

    /**
     * @param string $email
     * @return void
     */
    public function sendResetLetter(string $email): void
    {
        $key = User::find()->select('secret_key')->where(['email' => $email])->one();
        Yii::$app->mailer->compose()
            ->setFrom(self::SHOP_EMAIL)
            ->setTo($email)
            ->setSubject(self::TOPIC)
            ->setTextBody(Yii::$app->homeUrl . '/user/sign-in/reset-password?key=' . $key['secret_key'])
            ->send();
    }

    /**
     * @return void
     * @throws Exception
     */
    public function changePassword(): void
    {
        $key = Yii::$app->request->post()['key'];
        $user = User::findBySecretKey($key);
        $user->setPassword(Yii::$app->request->post()['password']);
        $user->secret_key = null;
        $user->save();
    }
}
