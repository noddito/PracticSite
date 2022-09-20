<?php

use common\models\Category;
use common\models\Product;
use yii\bootstrap\Carousel;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $form ActiveForm
 * @var $pages Pagination
 * @var $categories Category
 * @var $models Product
 * @var $carouselData array|null
 */

?>
<div class="banners">
    <div class="top-banners">
        <div class="main-banner-holder">
            <img class="main-banner" src="<?= Yii::getAlias('@frontendUrl') . '/img/main-banner.jpg' ?>">
        </div>
        <div class="minor-banners">
            <?php
            if ($carouselData !== null) {
                echo Carousel::widget([
                    'items' => $carouselData,
                    'options' => ['class' => 'carousel slide', 'data-interval' => '4000'],
                    'controls' => [
                        '<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>',
                        '<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>'
                    ]
                ]);
            }
            ?>
        </div>
    </div>
    <div class="buttom-banners">
        <img class="flat-banner" src="<?= Yii::getAlias('@frontendUrl') . '/img/flat-banner.jpg' ?>">
    </div>
</div>
<br>
<div class="container categories">
    <?php
    foreach ($categories as $category) { ?>
            <a class="main-category-link" href="<?= Url::to(['site/category', 'category_id' => $category->id]) ?>">
                <div class="category-container">
                <h4><?= $category->name ?></h4>
                </div>
            </a>
    <?php } ?>
</div>
