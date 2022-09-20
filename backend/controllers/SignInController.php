<?php

declare(strict_types=1);

namespace backend\controllers;

use backend\models\AccountForm;
use backend\models\LoginForm;
use JetBrains\PhpStorm\ArrayShape;
use Yii;
use yii\base\Exception;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\Response;

class SignInController extends Controller
{
    public $defaultAction = 'login';

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
                    'logout' => ['post']
                ]
            ]
        ];
    }

    /**
     * @return Response|string
     * @throws ForbiddenHttpException
     */
    public function actionLogin(): Response|string
    {
        $this->layout = 'base';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

    /**
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return Response|string
     */
    public function actionProfile(): Response|string
    {
        $model = Yii::$app->user->identity->userProfile;
        $post = Yii::$app->request->post();

        if ($model->load($post) && $model->save()) {
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your profile has been successfully saved', [], $model->locale)
            ]);

            return $this->refresh();
        }

        return $this->render('profile', ['model' => $model]);
    }

    /**
     * @return Response|string
     * @throws Exception
     */
    public function actionAccount(): Response|string
    {
        $user = Yii::$app->user->identity;
        $model = new AccountForm();
        $model->username = $user->username;
        $model->email = $user->email;
        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $user->username = $model->username;
            $user->email = $model->email;
            if ($model->password) {
                $user->setPassword($model->password);
            }
            $user->save();
            Yii::$app->session->setFlash('alert', [
                'options' => ['class' => 'alert-success'],
                'body' => Yii::t('backend', 'Your account has been successfully saved')
            ]);

            return $this->refresh();
        }

        return $this->render('account', ['model' => $model]);
    }
}
