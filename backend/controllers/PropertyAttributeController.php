<?php

declare(strict_types=1);

namespace backend\controllers;

use common\models\PropertyAttribute;
use common\models\search\PropertyAttributeSearch;
use JetBrains\PhpStorm\ArrayShape;
use yii\db\StaleObjectException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response as ResponseAlias;

/**
 * PropertyAttributeController implements the CRUD actions for PropertyAttribute model.
 */
class PropertyAttributeController extends Controller
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
     * Lists all PropertyAttribute models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new PropertyAttributeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PropertyAttribute model.
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
     * Creates a new PropertyAttribute model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|ResponseAlias
     */
    public function actionCreate(): ResponseAlias|string
    {
        $model = new PropertyAttribute();
        if ($model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PropertyAttribute model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|ResponseAlias
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id): ResponseAlias|string
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
     * Deletes an existing PropertyAttribute model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return ResponseAlias
     * @throws NotFoundHttpException|StaleObjectException if the model cannot be found
     */
    public function actionDelete(int $id): ResponseAlias
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PropertyAttribute model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return PropertyAttribute the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id): PropertyAttribute
    {
        if (($model = PropertyAttribute::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
