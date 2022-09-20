<?php

declare(strict_types=1);

namespace frontend\controllers;

use app\models\Basket;
use common\models\UserProfile;
use frontend\helpers\CreateUserOrder;
use frontend\helpers\MessageGenerator;
use frontend\helpers\SendOrder;
use JetBrains\PhpStorm\NoReturn;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class BasketController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex(): string
    {
        $basket = (new Basket())->getBasket();

        return $this->render('index', ['basket' => $basket]);
    }

    /**
     * @return Response
     */
    public function actionAdd(): Response
    {
        $basket = new Basket();
        $data = Yii::$app->request->post();
        if (!isset($data['id'])) {
            return $this->redirect(['site/index']);
        }
        if (!isset($data['count'])) {
            $data['count'] = 1;
        }
        $basket->addToBasket((int)$data['id'], $data['count']);

        if (isset($data['category_id'])) {
            return $this->response->redirect(['site/category?category_id=' . $data['category_id']]);
        }

        return $this->response->redirect(['site/index']);
    }

    /**
     * @param $id
     * @return Response|string
     */
    public function actionRemove($id): Response|string
    {
        $basket = new Basket();
        $basket->removeFromBasket($id);
        if (Yii::$app->request->isAjax) {
            $this->layout = false;
            $content = $basket->getBasket();

            return $this->render('modal', ['basket' => $content]);
        } else {
            return $this->redirect(['basket/index']);
        }
    }

    /**
     * @return Response|string
     */
    public function actionClear(): Response|string
    {
        $basket = new Basket();
        $basket->clearBasket();
        if (Yii::$app->request->isAjax) {
            $this->layout = false;
            $content = $basket->getBasket();

            return $this->render('modal', ['basket' => $content]);
        } else {
            return $this->response->redirect(['site/index']);
        }
    }

    /**
     * @return Response|string
     */
    public function actionUpdate(): Response|string
    {
        $basket = new Basket();
        $data = Yii::$app->request->post();
        if (!isset($data['count']) || !is_array($data['count'])) {
            return $this->redirect(['basket/index']);
        }
        $basket->updateBasket($data);

        return $this->response->redirect(['basket/index']);
    }

    /**
     * @return Response
     */
    #[NoReturn] public function actionPost(): Response
    {
        $createOrder = new CreateUserOrder();
        $message = new MessageGenerator();
        $sendOrder = new SendOrder();
        $createOrder->createOrder((int)Yii::$app->user->id, $message->createMessage(Yii::$app->request->post()), $message->getTotalCount());
        $sendOrder->sendEmail($message->getMessage(), Yii::$app->user->identity->email, $createOrder->returnOrderID());
        $phoneNumber = UserProfile::find()->select(['phone'])->where(['user_id' => Yii::$app->user->id])->one();
        if ($phoneNumber['phone'] !== null) {
            $sendOrder->sendSMS($createOrder->returnOrderID(), $phoneNumber['phone']);
        }
        self::actionClear();
        Yii::$app->session->setFlash('alert', [
            'options' => ['class' => 'alert-success'],
            'body' => Yii::t('frontend', 'Your order has been successfully created')
        ]);

        return $this->response->redirect(['site/index']);
    }
}
