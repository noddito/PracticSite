<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use common\models\ProductProperty;
use common\models\ProductVariableProperty;
use common\models\Property;
use common\models\PropertyAttribute;
use common\models\Status;
use common\models\TagProduct;
use common\models\UserOrder;
use common\models\VariableProperty;
use frontend\helpers\BannerHelper;
use frontend\helpers\ProductFilter;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use function PHPUnit\Framework\fileExists;

/**
 * Site controller
 */
class SiteController extends Controller
{
    private const PRODUCTS_MAX_COUNT = 8;
    private const ORDERS_MAX_COUNT = 8;

    public array $result;

    /**
     * @return string[][]
     */
    #[ArrayShape(['error' => "string[]"])]
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $carouselData = BannerHelper::getCarouselData();

        return $this->render('index', [
            'categories' => Category::find()->where(['parent_id' => null])->all(),
            'carouselData' => $carouselData,
        ]);
    }

    /**
     * @return string
     */
    public function actionCategory(): string
    {
        $get = Yii::$app->request->get();
        $productFilter = new ProductFilter();
        $category = new Category();
        $variablePropertyIds =
            ProductVariableProperty::find()->select('variable_property_id')->where(['category_id'=>(int)$get['category_id']])->column();
        $categories = Category::find()->where(['parent_id' => (int)$get['category_id']])->all();
        $categoriesIDs = $category->getChilds((int)$get['category_id']);
        if (isset($categoriesIDs[0])) {
            $query = $productFilter->getFilter($categoriesIDs);
        }
        elseif (isset($get['category_id']) && empty($categoriesIDs)) {
            $query = $productFilter->getFilter((int)$get['category_id']);
        }
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => self::PRODUCTS_MAX_COUNT]);

        return $this->render('category', [
            'pages' => $pages,
            'variablePropertiesList' => VariableProperty::getList($variablePropertyIds),
            'ProductVariableProperty' => ProductVariableProperty::getAttributesCount((int)$get['category_id']),
            'categories' => $categories,
            'models' => $query->select(['product_id'])->groupBy(['product_id'])->offset($pages->offset)->limit($pages->limit)->asArray()->all(),
            'categoriesIDs' => $categoriesIDs,
            'thisCategory' => $category->getNameById(),
            'attributesArray' => PropertyAttribute::getListByID($variablePropertyIds),
        ]);
    }

    /**
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'ProductProperty' => ProductProperty::find()->where(['product_id' => $id])->all(),
            'propertyNames' => Property::find()->select('name')->indexBy('id')->column(),
            'categoryName' => Category::find()->select('name')->indexBy('id')
                ->where(['id' => $this->findModel($id)->category_id])->column()[$this->findModel($id)->category_id],
            'variableProperties' => VariableProperty::find()->select('name')->indexBy('id')->column(),
            'tagProductList' => TagProduct::find()->select(['tag_id'])->where(['product_id' => $id])->column(),
        ]);
    }

    /**
     * @return array
     */
    public function getSearch(): array
    {
        $query = Product::find()->andWhere(['ilike', 'name', '%' . Yii::$app->request->get('query') . '%', false])->asArray()->all();

        return $query;
    }

    /**
     * @return string
     */
    public function actionSearch(): string
    {
        $query = $this->getSearch();

        return $this->render('search', [
            'query' => $query,
        ]);
    }

    /**
     * @return string
     */
    public function actionOrders(): string
    {
        $query = UserOrder::find()->with('user')->where(['user_id' => Yii::$app->user->id]);
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => self::ORDERS_MAX_COUNT]);

        return $this->render('orders', [
            'statusList' => Status::find()->select(['status'])->indexBy('id')->asArray()->column(),
            'orders' => $query->offset($pages->offset)->limit($pages->limit)->asArray()->all(),
            'pages' => $pages,
        ]);
    }

    /**
     * @return Response|string
     */
    public function actionProfile(): Response|string
    {
        $model = Yii::$app->user->identity->userProfile;
        $uploadedFile = UploadedFile::getInstance($model, 'avatar_path');
        $imageName = $model->avatar_path;
        if ($model->load(Yii::$app->request->post())) {
            if ($uploadedFile !== null) {
                if (fileExists(Yii::getAlias('@frontend') . '/web/img/user/' . $imageName)
                    && $model->avatar_path !== null && $imageName !== null) {
                    $model->deleteOldPhoto($imageName);
                }
                $model->avatar_path = $model->savePhoto($uploadedFile);
            } else {
                $model->avatar_path = $imageName;
            }
            $model->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
            ]);

            return $this->refresh();
        }

        return $this->render('profile', ['model' => $model]);
    }

    /**
     * @param int $id
     * @return Product
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Product
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
