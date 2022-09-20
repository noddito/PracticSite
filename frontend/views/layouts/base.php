<?php

use app\models\Basket;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Url;
use yii\web\View;

/**
 * @var $this View
 * @var $content string
 */


$this->beginContent('@frontend/views/layouts/_clear.php')
?>


<?php
NavBar::begin([
    'brandLabel' => 'Shop Name',
    'brandUrl' => ['/site/index'],
    'options' => [
        'class' => 'navbar-custom',
    ],
]); ?>

<form action="../basket/index" class="row cart-holder ">
    <?php $basket = (new Basket())->getBasket(); ?>
    <?php if (!empty($basket)) { ?>
        <p class="cart-amount"><?= $basket['amount'] . Yii::t('frontend', 'Rub.') ?></p>
    <?php } ?>
    <button type="submit" title="Shopping cart" class="glyphicon glyphicon-shopping-cart cart"></button>
</form>
<?php if (Yii::$app->user->identity !== null) {
$image = Yii::getAlias('@frontendUrl') . '/img/miniatures/' . Yii::$app->user->identity->userProfile->avatar_path;
if (empty(Yii::$app->user->identity->userProfile->avatar_path)) {
    $image = Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg';
} }?>
<?php echo Nav::widget([
    'options' => ['class' => 'navbar-custom navbar-right'],
    'items' => [
        ['label' => Yii::t('frontend', 'Login'), 'url' => ['/user/sign-in/login'], 'visible' => Yii::$app->user->isGuest],
        [
            'label' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->getPublicIdentity(),
            'visible' => !Yii::$app->user->isGuest,
            'items' => [
                [
                    'label' => Yii::t('frontend', 'Profile'),
                    'visible' => !Yii::$app->user->isGuest,
                    'url' => ['site/profile'],
                ],
                [
                    'label' => Yii::t('frontend', 'Send Message'),
                    'visible' => !Yii::$app->user->isGuest,
                    'url' => ['post-service/index'],
                ],
                [
                    'label' => Yii::t('frontend', 'Orders'),
                    'visible' => !Yii::$app->user->isGuest,
                    'url' => ['site/orders'],
                ],
                [
                    'label' => Yii::t('frontend', 'Logout'),
                    'url' => ['/user/sign-in/logout'],
                    'linkOptions' => ['data-method' => 'post'],
                ],
            ],
        ],

    ],
]); ?>
<div>
    <img style="width: 100px" src="<?= Yii::getAlias('@frontendUrl') . '/img/logo.jpg' ?>" alt="">
</div>
<div>

    <div class="wrap col">
        <div>
            <div>
                <div>
                    <form method="get" action="<?= Url::to(['site/search']); ?>" class="pull-right">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Поиск товаров по сайту">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php NavBar::end(); ?>

            <?php echo $content ?>

        </div>

    </div>
    <?php $this->endContent() ?>
