<?php

declare(strict_types=1);

namespace common\models;

use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "categories".
 * @property int $id
 * @property string name
 * @property Product[] $products
 * @property Category $category
 * @property int|mixed|null $parentId
 */
class Category extends ActiveRecord
{
    public array $category = [];
    public array $categoryIDs = [];

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
        return 'categories';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 40],
            [['description'], 'string'],
            [['id'], 'integer'],
            [['parent_id'], 'integer'],
        ];
    }

    /**
     * @return array
     */
    #[ArrayShape(['id' => "string", 'name' => "string", 'updated_at' => "string", 'created_at' => "string", 'description' => "string", 'parent_id' => "string"])]
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('common', 'Category ID'),
            'name' => Yii::t('common', 'Category Name'),
            'updated_at' => Yii::t('common', 'Updated At'),
            'created_at' => Yii::t('common', 'Created At'),
            'description' => Yii::t('common', 'Description'),
            'parent_id' => Yii::t('common', 'Parent ID'),
        ];
    }

    /**
     * @return array
     */
    public static function getCategoryMap(): array
    {
        return Category::find()->select('name')->indexBy('id')->column();
    }

    /**
     * @return array
     */
    public static function getList(): array
    {
        return self::find()->select(['name'])->indexBy('id')->column();
    }

    /**
     * @return array|ActiveRecord|null
     */
    public function getNameById(): ?ActiveRecord
    {
        return Category::find()->select('name')->where(['id' => Yii::$app->request->get()['category_id']])->one();
    }

    /**
     * @return array
     */
    private function getCategoryArray(): array
    {
        $result = $this->find()->all();
        $categoryArray = [];
        foreach ($result as $value) {
            $categoryArray[$value->parent_id][] = $value;
        }

        return $categoryArray;
    }

    /**
     * @param int|null $parentId
     * @param int|null $treeLevel
     * @return void
     */
    public function buildTree(?int $parentId, ?int $treeLevel): void
    {
        $this->category = $this->getCategoryArray();
        if (isset($this->category[$parentId])) {
            foreach ($this->category[$parentId] as $value) {
                $counter = 0;
                while ($treeLevel > $counter) {
                    echo '- ';
                    $counter++;
                }
                echo $value->name . "";
                echo '<br>';
                $treeLevel++;
                $this->buildTree($value->id, $treeLevel);
                $treeLevel--;
            }
        }
    }

    /**
     * @param int|null $parentId
     * @return array
     */
    public function getChilds(?int $parentId): array
    {
        $this->category = $this->getCategoryArray();
        if (isset($this->category[$parentId])) {
            foreach ($this->category[$parentId] as $value) {
                $this->categoryIDs[] = $value->id;
            }
        }

        return $this->categoryIDs;
    }
}
