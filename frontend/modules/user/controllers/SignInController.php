<?php

namespace frontend\modules\user\controllers;

use app\models\ResetPassword;
use backend\models\UserForm;
use common\models\User;
use frontend\modules\user\models\LoginForm;
use Yii;
use yii\base\Exception;
use yii\web\Response;

class SignInController extends \yii\web\Controller
{
    public $layout = 'login';

    /**
     * @return array|string|Response
     */
    public function actionLogin(): Response|array|string
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionRegistraion(): string|Response
    {
        $model = new UserForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['login']);
        }

        return $this->render('registraion', [
            'model' => $model,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionRecoveryPass(): string|Response
    {
        $post = Yii::$app->request->post();
        if (!empty($post) && isset($post['User']['email'])) {
            $model = User::findByEmail($post['User']['email']);
            if (empty($model)) {
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-info'],
                    'body' => Yii::t('frontend', 'There is no account with this email, please register')
                ]);
                $model = new UserForm();

                return $this->render('registraion', [
                    'model' => $model,
                ]);
            } else {
                $reset = new ResetPassword();
                $reset->createSecretKey($post['User']['email']);
                Yii::$app->session->setFlash('alert', [
                    'options' => ['class' => 'alert-success'],
                    'body' => Yii::t('frontend', 'A password recovery email has been sent to your email')
                ]);

                return $this->redirect(['login']);
            }
        }
        $model = new User();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['login']);
        }

        return $this->render('recovery-pass', [
            'model' => $model,
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

    public function actionResetPassword(): Response|string
    {
        if (!empty(Yii::$app->request->get())) {
            $user = User::findBySecretKey(Yii::$app->request->get()['key']);
        } else {
            $user = User::findBySecretKey(Yii::$app->request->post()['key']);
        }
        $model = new ResetPassword();
        if ($user !== null) {
            if (Time() >= $user->is_valid_until) {
                $user->is_valid_until = null;
                $user->secret_key = null;
                $user->save();
            }
            if (!empty(Yii::$app->request->get())) {
                $secret_key = User::find()->select(['secret_key'])->where(['secret_key' => Yii::$app->request->get()['key']])->one();
                if ($secret_key !== null) {
                    if (key(Yii::$app->request->get()) === 'key' && $secret_key['secret_key'] === Yii::$app->request->get()['key']) {

                        return $this->render('reset-password', [
                            'model' => $model,
                        ]);
                    }
                }
            }
            if (!empty(Yii::$app->request->post()['password']) && !empty(Yii::$app->request->post()['password2']) && !empty(Yii::$app->request->post())) {
                if (Yii::$app->request->post()['password'] !== Yii::$app->request->post()['password2']) {
                    Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-warning'],
                        'body' => Yii::t('frontend', 'The entered passwords do not match', [])
                    ]);

                    return $this->redirect(Yii::$app->homeUrl . '/user/sign-in/reset-password?key=' . Yii::$app->request->post()['key']);
                }
                $model->changePassword();
                Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-success'],
                        'body' => Yii::t('frontend', 'Password has been changed')]
                );
            } elseif (!empty(Yii::$app->request->post())) {
                Yii::$app->session->setFlash('alert', [
                        'options' => ['class' => 'alert-warning'],
                        'body' => Yii::t('frontend', 'You have not entered a password', [])]
                );

                return $this->redirect(Yii::$app->homeUrl . '/user/sign-in/reset-password?key=' . Yii::$app->request->post()['key']);
            }
        }

        return $this->redirect(['login']);
    }
}
