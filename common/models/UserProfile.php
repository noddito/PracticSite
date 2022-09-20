<?php

declare(strict_types=1);

namespace common\models;

use backend\helpers\EditPhoto;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use function PHPUnit\Framework\fileExists;

/**
 * This is the model class for table "user_profile".
 * @property integer $user_id
 * @property integer $locale
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $avatar_path
 * @property string $avatar_base_url
 * @property integer $gender
 * @property User $user
 */
class UserProfile extends ActiveRecord
{
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    private const PRODUCT_PHOTO_PATH = '/web/img/user/';
    private const PRODUCT_PHOTO_MINIATURE_PATH = '/web/img/miniatures/';

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return '{{%user_profile}}';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'gender'], 'integer'],
            [['avatar_path'], 'file', 'extensions' => 'png , jpg , jpeg'],
            [['gender'], 'in', 'range' => [NULL, self::GENDER_FEMALE, self::GENDER_MALE]],
            [['firstname', 'middlename', 'lastname', 'avatar_base_url'], 'string', 'max' => 255],
            ['locale', 'default', 'value' => Yii::$app->language],
            ['locale', 'in', 'range' => array_keys(Yii::$app->params['availableLocales'])],
            ['phone', 'integer']
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['user_id' => "string", 'firstname' => "string", 'middlename' => "string", 'lastname' => "string", 'locale' => "string", 'gender' => "string", 'avatar_path' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'user_id' => Yii::t('common', 'User ID'),
            'firstname' => Yii::t('common', 'Firstname'),
            'middlename' => Yii::t('common', 'Middlename'),
            'lastname' => Yii::t('common', 'Lastname'),
            'locale' => Yii::t('common', 'Locale'),
            'gender' => Yii::t('common', 'Gender'),
            'avatar_path' => Yii::t('common', 'Avatar Image'),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * @return null|string
     */
    public function getFullName(): ?string
    {
        if ($this->firstname || $this->lastname) {
            return implode(' ', [$this->firstname, $this->lastname]);
        }

        return null;
    }

    /**
     * @param null $default
     * @return bool|null|string
     */
    public function getAvatar($default = null): bool|string|null
    {
        return $this->avatar_path
            ? Yii::getAlias($this->avatar_base_url . '/' . $this->avatar_path)
            : $default;
    }

    /**
     * @param $image
     * @return bool|string
     */
    public function savePhoto($image): bool|string
    {
        return EditPhoto::savePhoto($image, self::PRODUCT_PHOTO_PATH, self::PRODUCT_PHOTO_MINIATURE_PATH);
    }

    /**
     * @param string $imageName
     * @return void
     */
    public function deleteOldPhoto(string $imageName): void
    {
        if (fileExists(Yii::getAlias('@frontend') . '/web/img/user/' . $imageName) &&
            $imageName !== $this->avatar_path && $this->avatar_path !== null) {
            EditPhoto::deletePhoto($imageName, '/web/img/user/', '/web/img/miniatures/');
        }
    }
}
