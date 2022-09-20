<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\search\UserOrderSearch;
use common\models\UserOrder;
use JetBrains\PhpStorm\ArrayShape;
use yii\data\Pagination;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * UserOrderController implements the CRUD actions for UserOrder model.
 */
class UserOrderController extends Controller
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
     * Lists all UserOrder models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new UserOrderSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages' => new Pagination(['totalCount' => $dataProvider->totalCount, 'pageSize' => self::PRODUCTS_MAX_COUNT]),
        ]);
    }

    /**
     * Displays a single UserOrder model.
     * @param int $order_id Order ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $order_id): string
    {
        return $this->render('view', [
            'model' => $this->findModel($order_id),
        ]);
    }

    /**
     * Creates a new UserOrder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|Response
     */
    public function actionCreate(): Response|string
    {
        $model = new UserOrder();
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserOrder model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $order_id Order ID
     * @return string|Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $order_id): Response|string
    {
        $model = $this->findModel($order_id);
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index', 'order_id' => $model->order_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UserOrder model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $order_id Order ID
     * @return Response
     * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
     */
    public function actionDelete(int $order_id): Response
    {
        $this->findModel($order_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserOrder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $order_id Order ID
     * @return UserOrder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $order_id): UserOrder
    {
        if (($model = UserOrder::findOne(['order_id' => $order_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
