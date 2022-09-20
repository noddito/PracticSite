<?php

declare(strict_types=1);

namespace frontend\controllers;

use common\models\Product;
use common\models\search\ProductSearch;
use common\models\User;
use frontend\helpers\SendEmail;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Site controller
 */
class PostServiceController extends Controller
{
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
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        ]);
    }

    /**
     * @throws NotFoundHttpException
     */
    protected function findModel(int $id): Product
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return Response
     */
    public function actionPost(): Response
    {
        $userAddress = User::find()->select('email')->where(['id' => Yii::$app->user->id])->column();
        SendEmail::sendMessage(Yii::$app->request->post(), $userAddress[0]);
        Yii::$app->session->setFlash('alert', [
            'options' => ['class' => 'alert-success'],
            'body' => Yii::t('frontend', 'Your message has been successfully sent')
        ]);

        return $this->response->redirect(['post-service/index']);
    }
}
