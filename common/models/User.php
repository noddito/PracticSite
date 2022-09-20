<?php

declare(strict_types=1);

namespace common\models;

use common\models\query\UserQuery;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use Yii;
use yii\base\Exception;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $email
 * @property string $auth_key
 * @property string $access_token
 * @property string $oauth_client
 * @property string $oauth_client_user_id
 * @property string $publicIdentity
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $logged_at
 * @property string $password write-only password
 * @property UserProfile $userProfile
 * @method static class()
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETED = 3;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMINISTRATOR = 'administrator';

    const EVENT_AFTER_SIGNUP = 'afterSignup';
    const EVENT_AFTER_LOGIN = 'afterLogin';

    private string|null $secret_key;
    private int|null $is_valid_until;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public static function findBySecretKey($key): ?User
    {
        return static::findOne([
            'secret_key' => $key,
        ]);
    }

    /**
     * @return array
     */
    #[ArrayShape(['username' => "string", 'email' => "string", 'status' => "string", 'access_token' => "string", 'created_at' => "string", 'updated_at' => "string", 'logged_at' => "string", 'is_valid_until' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'username' => Yii::t('common', 'Username'),
            'email' => Yii::t('common', 'E-mail'),
            'status' => Yii::t('common', 'User Status'),
            'access_token' => Yii::t('common', 'API access token'),
            'created_at' => Yii::t('common', 'Created at'),
            'updated_at' => Yii::t('common', 'Updated at'),
            'logged_at' => Yii::t('common', 'Last login'),
            'is_valid_until' => Yii::t('common', 'Key is valid until'),
        ];
    }

    /**
     * @return array
     * @throws Exception
     */
    #[ArrayShape([0 => "string", 'auth_key' => "array", 'access_token' => "array"])]
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
            'auth_key' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'auth_key'
                ],
                'value' => Yii::$app->getSecurity()->generateRandomString()
            ],
            'access_token' => [
                'class' => AttributeBehavior::class,
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'access_token'
                ],
                'value' => function () {
                    return Yii::$app->getSecurity()->generateRandomString(40);
                }
            ]
        ];
    }

    /**
     * @return array
     */
    public function scenarios(): array
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'oauth_create' => [
                    'oauth_client', 'oauth_client_user_id', 'email', 'username', '!status'
                ]
            ]
        );
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['username', 'email'], 'unique'],
            ['status', 'default', 'value' => self::STATUS_NOT_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::statuses())],
            [['username'], 'filter', 'filter' => '\yii\helpers\Html::encode'],
            [['is_valid_until'], 'integer'],
        ];
    }

    /**
     * @param $id
     * @return array|ActiveRecord|IdentityInterface|null
     */
    public static function findIdentity($id): array|ActiveRecord|IdentityInterface|null
    {
        return static::find()
            ->active()
            ->andWhere(['id' => $id])
            ->one();
    }

    /**
     * @return UserQuery
     */
    public static function find(): UserQuery
    {
        return new UserQuery(get_called_class());
    }

    /**
     * @param $token
     * @param $type
     * @return array|ActiveRecord|IdentityInterface|null
     */
    public static function findIdentityByAccessToken($token, $type = null): array|ActiveRecord|IdentityInterface|null
    {
        return static::find()
            ->active()
            ->andWhere(['access_token' => $token])
            ->one();
    }

    /**
     * @return mixed
     */
    public function getId(): mixed
    {
        return $this->getPrimaryKey();
    }

    /**
     * @param $authKey
     * @return bool
     */
    #[Pure] public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return string
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * @param string $username
     * @return User|array|null
     */
    public static function findByUsername(string $username): User|array|null
    {
        return static::find()
            ->active()
            ->andWhere(['username' => $username])
            ->one();
    }

    /**
     * @param string $email
     * @return User|array|null
     */
    public static function findByEmail(string $email): User|array|null
    {
        return static::find()
            ->active()
            ->andWhere(['email' => $email])
            ->one();
    }

    /**
     * @param string $login
     * @return User|array|null
     */
    public static function findByLogin(string $login): User|array|null
    {
        return static::find()
            ->active()
            ->andWhere(['or', ['username' => $login], ['email' => $login]])
            ->one();
    }

    /**
     * @return array
     */
    #[ArrayShape([self::STATUS_NOT_ACTIVE => "string", self::STATUS_ACTIVE => "string", self::STATUS_DELETED => "string"])]
    public static function statuses(): array
    {
        return [
            self::STATUS_NOT_ACTIVE => Yii::t('common', 'Not Active'),
            self::STATUS_ACTIVE => Yii::t('common', 'Active'),
            self::STATUS_DELETED => Yii::t('common', 'Deleted')
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUserProfile(): ActiveQuery
    {
        return $this->hasOne(UserProfile::class, ['user_id' => 'id']);
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     * @param string $password
     * @throws Exception
     */
    public function setPassword(string $password): void
    {
        $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    /**
     * Creates user profile and application event
     * @param array $profileData
     * @throws \Exception
     */
    public function afterSignup(array $profileData = []): void
    {
        $this->refresh();
        $profile = new UserProfile();
        $profile->locale = Yii::$app->language;
        $profile->load($profileData, '');
        $this->link('userProfile', $profile);
        $this->trigger(self::EVENT_AFTER_SIGNUP);
        // Default role
        $auth = Yii::$app->authManager;
        $auth->assign($auth->getRole(User::ROLE_USER), $this->getId());
    }

    /**
     * @return string
     */
    #[Pure] public function getPublicIdentity(): string
    {
        if ($this->userProfile && $this->userProfile->getFullname()) {
            return $this->userProfile->getFullname();
        }

        if ($this->username) {
            return $this->username;
        }

        return $this->email;
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        return self::find()->select(['username'])->indexBy('id')->column();
    }
}
