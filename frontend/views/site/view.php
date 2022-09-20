<?php

use app\models\Basket;
use common\models\ProductVariableProperty;
use common\models\PropertyAttribute;
use common\models\Tag;
use common\models\VariableProperty;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\YiiAsset;

/* @var $this yii\web\View
 * @var $ProductProperty
 * @var $propertyNames
 * @var $PropertyAttribute
 * @var $variableProperties
 * @var $categoryName
 * @var $tagProductList
 * @var $model VariableProperty
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'site', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="variable-properties-view row container">
    <?php $image = Yii::getAlias('@frontendUrl') . '/img/products/' . $model->image;
    if ($model->image === null || empty($model->image)) {
        $image = Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg';
    } ?>
    <div class="row">
        <img class="product-image col-sm-5 col-md-6" src='<?= $image ?>' alt="">
        <div class="product-main-info col-sm-5 offset-sm-2 col-md-6 offset-md-0">
            <h3 class="product-name"><?= Yii::t('frontend', 'Name :') ?> <?= $model->name ?></h3>
            <h3 class="product-category"><?= Yii::t('frontend', 'Category :') ?> <?= $categoryName; ?> </h3>
            <h3 class="product-price"><?= Yii::t('frontend', 'Price :') ?> <?= $model->price ?> <?= Yii::t('frontend', 'Rub.') ?></h3>
            <p class="product-count-view"> <?= Yii::t('frontend', 'In cart : ') .
                Basket::returnCountByID($model->id) . ' ' . Yii::t('frontend', 'psc') ?></p>
            <div class="col">
                <?php
                foreach ($tagProductList as $value) {
                    $tagNames = Tag::find()->select(['name'])->where(['id' => $value])->all(); ?>
                    <?php foreach ($tagNames as $tagName) { ?>
                        <p class="tag-name"><?= $tagName['name'] ?></p>
                    <?php }
                }
                ?>
            </div>
            <form method="post"
                  action="<?= Url::to(['basket/add']); ?>">
                <input type="hidden" name="id" value="<?= $model->id; ?>">
                <input type="hidden" name="category_id" value="<?= $model->category_id; ?>">
                <?=
                Html::hiddenInput(
                    Yii::$app->request->csrfParam,
                    Yii::$app->request->csrfToken,
                );
                ?>
                <input type="submit" class="add-to-cart-button" value="<?= Yii::t('frontend', 'Add to cart') ?>">
            </form>
        </div>
    </div>

    <div>
        <div class="description col-6 col-md-4">
            <h3 class="product-description"><?= $model->description ?></h3>
        </div>

    </div>
    <div class="variable-properties col-md-3 offset-md-3">
        <?php foreach ($variableProperties as $variableProperty) { ?>
            <?php if (!empty(ProductVariableProperty::getListById($model->id, key($variableProperties)))) { ?>
                <h3 class="variable-property-name"> <?= $variableProperty ?> </h3>
            <?php } ?>
            <?php foreach (ProductVariableProperty::getListById($model->id, key($variableProperties)) as $variableAttributesID) { ?>
                <p><?= PropertyAttribute::getListByAttributeId($variableAttributesID['attribute_id'])[0] ?></p>
            <?php } ?>
            <?php next($variableProperties); ?>
        <?php } ?>
    </div>

    <div class="properties col-6 col-md-4">
        <?php foreach ($ProductProperty as $property) { ?>
            <?php if (!empty($property->value)) { ?>
                <h4 class="property-name"> <?= $propertyNames[$property->properties_id] ?>
                    : <?= $property->value ?></h4>
            <?php } ?>
        <?php } ?>
    </div>
