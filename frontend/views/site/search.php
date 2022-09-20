<?php

declare(strict_types=1);


/** @var yii\web\View $this
 * @var $models
 * @var $query
 */

?>
<div class="row">
    <?php
    $counter = 0;
    foreach ($query

    as $item) { ?>
    <?php $image = Yii::getAlias('@frontendUrl') . '/img/miniatures/' . $item['image'];
    if ($item['image'] === null || empty($item['image'])) {
        $image = Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg';
    } ?>
    <a class="product-link" href="view?id=<?= $item['id'] ?>">
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
            <div class="thumbnail product-container link">
                <img src='<?= $image ?>' width="100" height="100" alt="">
                <div>
                    <h3 class="product-name"><?= $item['name'] ?></h3>
                    <p class="product-price"><?= $item['price'] . Yii::t('frontend', 'Rub.') ?></p>
                    <p><a href="" class="add-to-cart-button" role="button"><?= Yii::t('frontend', 'Add to cart') ?></a>
                    </p>
                </div>
            </div>
    </a>
</div>
<?php
$counter++;
} ?>

