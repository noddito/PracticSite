<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\search\VariablePropertySearch;
use common\models\VariableProperty;
use JetBrains\PhpStorm\ArrayShape;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * VariablePropertyController implements the CRUD actions for VariableProperty model.
 */
class VariablePropertyController extends Controller
{
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
     * Lists all VariableProperty models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new VariablePropertySearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VariableProperty model.
     * @param int $id VariableProperty ID
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
     * Creates a new VariableProperty model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return Response|string
     */
    public function actionCreate(): Response|string
    {
        $model = new VariableProperty();
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing VariableProperty model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id VariableProperty ID
     * @return Response|string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): Response|string
    {
        $model = $this->findModel($id);
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing VariableProperty model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id VariableProperty ID
     * @return Response
     * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
     */
    public function actionDelete(int $id): Response
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the VariableProperty model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id VariableProperty ID
     * @return VariableProperty the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): VariableProperty
    {
        if (($model = VariableProperty::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
