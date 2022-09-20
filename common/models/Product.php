<?php

declare(strict_types=1);

namespace common\models;

use backend\helpers\EditPhoto;
use backend\helpers\UsdCourse;
use Yii;
use yii\base\InvalidConfigException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\httpclient\Exception;
use yii\web\UploadedFile;
use function PHPUnit\Framework\fileExists;

/**
 * This is the model class for table "product".
 * @property PropertyAttribute[]|null $attributeNames
 * @property integer $id
 * @property integer $price
 * @property integer $price_usd
 * @property integer $category_id
 * @property integer $counter
 * @property string $name
 * @property string $description
 * @property string $image
 * @property string $oldName
 * @property string $key
 * @property array|string $tagsArray
 * @property array|string $propertyArray
 * @property array|string $propertiesValue
 * @property array|string $variablePropertyArray
 * @property array|string $sortedAttributesArray
 * @property mixed|null $tags
 */
class Product extends ActiveRecord
{
    private const PRODUCT_PHOTO_PATH = '/web/img/products/';
    private const PRODUCT_PHOTO_MINIATURE_PATH = '/web/img/miniatures/';

    public array|string $tagsArray = [];
    public array|string $propertyArray = [];
    public array|string $propertiesValue = [];
    public array|string $variablePropertyArray = [];
    public array|string $sortedAttributesArray = [];
    public array|string $attributesArray = [];

    public string $oldName;
    public int $counter = 0;

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'products';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['category_id'], 'default', 'value' => null],
            [['category_id'], 'required'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['name'], 'string', 'max' => 32],
            [['description'], 'string'],
            [['tagsArray'], 'safe'],
            [['variablePropertyArray'], 'safe'],
            [['sortedAttributesArray'], 'safe'],
            [['attributesArray'], 'safe'],
            [['propertyArray'], 'safe'],
            [['updated_at'], 'integer'],
            [['created_at'], 'integer'],
            [['price'], 'double', 'min' => 0],
            [['price_usd'], 'double', 'min' => 0],
            [['image'], 'file', 'extensions' => 'png , jpg , jpeg'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('common', 'Product Name'),
            'description' => Yii::t('common', 'Description'),
            'category_id' => Yii::t('common', 'Category Name'),
            'tagsArray' => Yii::t('common', 'Product Tags'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
            'price' => Yii::t('common', 'Price'),
            'price_usd' => Yii::t('common', 'Price Usd'),
            'image' => Yii::t('common', 'Image'),
        ];
    }

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
     * @param $insert
     * @param $changedAttributes
     * @return void
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes): void
    {
        $this->saveTags();
        $this->saveProperties();
        $this->saveVariableProperties();
    }

    /**
     * @return void
     */
    public function afterDelete(): void
    {
        if ($this->image !== null) {
            EditPhoto::deletePhoto
            ($this->image, self::PRODUCT_PHOTO_PATH, self::PRODUCT_PHOTO_MINIATURE_PATH);
        }
    }

    /**
     * Gets query for [[Category]].
     * @return ActiveQuery
     */
    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[TagProduct]].
     * @return ActiveQuery
     */
    public function getTagProducts(): ActiveQuery
    {
        return $this->hasMany(TagProduct::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags(): ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagProducts');
    }

    /**
     * @return ActiveQuery
     */
    public function getProductVariableProperty(): ActiveQuery
    {
        return $this->hasMany(ProductVariableProperty::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getAttributeNames(): ActiveQuery
    {
        return $this->hasMany(PropertyAttribute::class, ['id' => 'attribute_id'])->via('productVariableProperty');
    }

    /**
     * @return void
     */
    public function getProducts(): void
    {
        $this->propertiesValue = ProductProperty::find()->where(['product_id' => $this->id])->all();
        $this->tagsArray = $this->tags;
        $this->variablePropertyArray = $this->getSortedAttributesArray();
    }

    /**
     * @return array|string
     */
    private function getSortedAttributesArray(): array|string
    {
        $data = $this->getAttributeNames()->asArray()->all();
        foreach ($data as $row) {
            $this->sortedAttributesArray[$row['property_id']][] = $row['id'];
        }

        return $this->sortedAttributesArray;
    }

    /**
     * @return array
     */
    public static function getTagMap(): array
    {
        return Tag::find()->select('name')->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public static function getCategoryMap(): array
    {
        return Category::find()->select('name')->indexBy('id')->column();
    }

    /**
     * @param $id
     * @return array
     */
    public function getVariablePropertyMap($id): array
    {
        return PropertyAttribute::find()->select('name')->where(['property_id' => $id])->indexBy('id')->column();
    }

    /**
     * @return void
     */
    private function saveTags(): void
    {
        $array = ArrayHelper::map($this->tags, 'id', 'id');
        if ($this->tagsArray) {
            foreach ($this->tagsArray as $tags) {
                if (in_array($tags, $array) === false) {
                    $model = new TagProduct();
                    $model->product_id = $this->id;
                    $model->tag_id = $tags;
                    $model->save();
                }
                if (isset($array[$tags])) {
                    unset($array[$tags]);
                }
            }
        }
        TagProduct::deleteAll(['tag_id' => $array, 'product_id' => $this->id]);
    }

    /**
     * @return void
     * @throws \yii\db\Exception
     */
    private function saveProperties(): void
    {
        ProductProperty::deleteAll(['product_id' => $this->id]);
        $productPropertiesArray = [];
        $counter = 0;
        foreach ($this->propertyArray as $property) {
            $productPropertiesArray[$counter] = array('product_id' => $this->id, 'properties_id' => key($this->propertyArray), 'value' => $property);
            $counter++;
            next($this->propertyArray);
        }
        Yii::$app->db->createCommand()->batchInsert('product_properties', ['product_id', 'properties_id', 'value'], $productPropertiesArray)->execute();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function showProperties(): mixed
    {
        $propertyValueArray = ArrayHelper::getColumn(ProductProperty::find()->where(['product_id' => $this->id])->all(), 'value');
        $value = ArrayHelper::getValue($propertyValueArray, [$this->counter]);
        $this->counter++;

        return $value;
    }

    /**
     * @return void
     * @throws \yii\db\Exception
     */
    private function saveVariableProperties(): void
    {
        ProductVariableProperty::deleteAll(['product_id' => $this->id]);
        $ProductVariableProperty = [];
        $counter = 0;
        foreach ($this->variablePropertyArray as $property) {
            if (is_array($property)) {
                foreach ($property as $attribute) {
                    $productVariableProperties[$counter] =
                        ['product_id' => $this->id, 'variable_property_id' => key($this->variablePropertyArray),
                            'attribute_id' => $attribute, 'category_id' => $this->category_id];
                    $counter++;
                }
                next($property);
            }
            next($this->variablePropertyArray);
        }
        Yii::$app->db->createCommand()
            ->batchInsert('product_variable_properties', ['product_id', 'variable_property_id', 'attribute_id', 'category_id'], $productVariableProperties)->execute();
    }

    /**
     * @return int
     */
    public function countOfVariableProperties(): int
    {
        return count(ProductVariableProperty::find()->where(['product_id' => $this->id])->all());
    }

    /**
     * @param UploadedFile $image
     * @return bool|string
     */
    public function savePhoto(UploadedFile $image): bool|string
    {
        return EditPhoto::savePhoto($image, self::PRODUCT_PHOTO_PATH, self::PRODUCT_PHOTO_MINIATURE_PATH);
    }

    /**
     * @param string $imageName
     * @return void
     */
    public function deleteOldPhoto(string $imageName): void
    {
        if (fileExists(Yii::getAlias('@frontend') . '/web/img/products/' . $imageName) &&
            $imageName !== $this->image && $this->image !== null) {
            EditPhoto::deletePhoto($imageName, '/web/img/products/', '/web/img/miniatures/');
        }
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return Yii::getAlias('@frontendUrl') . '/img/miniatures/' . $this->image;
    }

    /**
     * @return string
     */
    public function getStub(): string
    {
        return Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg';
    }

    /**
     * @return float
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function getPriceUsd(): float
    {
        if ($this->price > 0 && $this->price != null) {
            $usd_course = UsdCourse::getUsdCourse();
            if ($usd_course > 0) {
                return $this->price / $usd_course;
            }
        }

        return $this->price = 0;
    }
}
