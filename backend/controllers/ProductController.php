<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\Product;
use common\models\search\ProductSearch;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\Pagination;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\httpclient\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use function PHPUnit\Framework\fileExists;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    private const PRODUCTS_MAX_COUNT = 6;

    /**
     * @return array[]
     */
    #[ArrayShape(['verbs' => "array"])]
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Product models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => new Pagination(['totalCount' => $dataProvider->totalCount, 'pageSize' => self::PRODUCTS_MAX_COUNT]),
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function actionCreate(): Response|string
    {
        $model = new Product();
        $uploadedFile = UploadedFile::getInstance($model, 'image');
        if ($model->load($this->request->post())) {
            $model->price_usd = $model->getPriceUsd();
            if ($uploadedFile !== null) {
                $model->image = $model->savePhoto($uploadedFile);
            } else {
                $model->image = null;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     * @throws InvalidConfigException
     * @throws Exception
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);
        $imageName = $model->image;
        $uploadedFile = UploadedFile::getInstance($model, 'image');
        $model->getProducts();
        if ($model->load($this->request->post())) {
            $model->price_usd = $model->getPriceUsd();
            if ($uploadedFile !== null) {
                if (fileExists(Yii::getAlias('@frontend') . '/web/img/products/' . $imageName) &&
                    $imageName !== $model->image && $model->image !== null && $imageName !== null) {
                    $model->deleteOldPhoto($imageName);
                }
                $model->image = $model->savePhoto($uploadedFile);
            } else {
                $model->image = $imageName;
            }
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return Response
     * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): Product
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
