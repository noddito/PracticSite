<?php

use common\models\Category;
use common\models\Product;
use common\models\search\ProductSearch;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/**
 * @var $categories Category
 * @var $thisCategory Category
 * @var $models Product
 * @var $categoriesIDs array
 * @var $pages Pagination
 * @var $dataProvider ProductSearch
 * @var $variablePropertiesList array
 * @var $ProductVariableProperty array
 * @var $attributesArray array
 */

?>

<div class="main-category-name">
    <h1><?= $thisCategory['name']; ?></h1>
</div>

<?php if (empty($models) && empty($categoriesIDs)) { ?>
    <h1 class="no-models">В этой категории нет товаров</h1>
<?php } ?>

<?php if (empty($categoriesIDs)) {
    $categoriesIDs = (int)Yii::$app->request->get()['category_id'];
    if (!empty($models)) {
        ?>
        <div class="row">
        <div class="col-md-2 filter-panel">
            <div class="sidebar">
                <div class="filter">
                    <form action="" class="filter_form" method="get">
                        <?php
                        $counter = 1;
                        foreach ($variablePropertiesList as $keyProperty => $variableProperty) { ?>
                            <div class="col" id="check_name">
                                <h4 class="variable-property-name"><?= $variablePropertiesList[$keyProperty] ?></h4>
                            </div>
                            <?php if ($counter === 1) { ?>
                                <?= Html::hiddenInput('category_id', Yii::$app->request->get()['category_id']); ?>
                            <?php } ?>
                            <?php foreach ($attributesArray as $key => $item) { ?>
                                <?php if ($keyProperty === $item["property_id"]) { ?>
                                    <div class="row" id="check_element">
                                        <?php foreach ($ProductVariableProperty as $keyValue => $attirbuteCount) {
                                            if ($keyValue === $item['id']) { ?>
                                                <input type="checkbox" name="<?= $keyProperty ?>[]"
                                                       class="form-check-input"
                                                       id="<?= $item['id'] ?>" value="<?= $key ?>">
                                                <label class="property-label"
                                                       for="<?= $item['name'] ?>"> <?= $item['name'] ?>  </label>
                                                <b class="property-count"><?= ' (' . $attirbuteCount . ')' ?></b>
                                            <?php }
                                        } ?>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                            <?php $counter++;
                        } ?>
                        <div class="col">
                            <div class="row">
                                <input class="button-find" type="submit" value="Найти">
                                <input class="button-reset" type="reset" value="Сбросить">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pagination">
                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            </div>
        </div>
        <div class="products-container">
        <?php foreach ($models as $key => $model) { ?>
            <?php if ($categoriesIDs === $model['product']['category_id'] || $model['product']['category_id'] == (int)Yii::$app->request->get()['category_id']) { ?>
                <div class="product-category-container thumbnail">
                    <a class=""
                       href="view?id=<?= $model['product']['id'] ?>&category_id=<?= $model['product']['category_id'] ?>">
                        <?php if ($model['product']['image'] !== null) { ?>
                            <img
                                src='<?= Yii::getAlias('@frontendUrl') . '/img/miniatures/' . $model['product']['image'] ?>'
                                width="100" height="100" alt="">
                        <?php } else { ?>
                            <img src='<?= Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg' ?>' width="100"
                                 height="100" alt="">
                        <?php } ?>
                        <div>
                            <p class="product-name"><?=$model['product']['name']?><sub><?=' '.$model['product']['price'].' руб'?></sub></p>

                    </a>
                </div>
                </div>
            <?php } ?>
        <?php }
    }
    echo '</div>';
} else { ?>
    <div class="container">
    <?php foreach ($categoriesIDs as $categoryID) { ?>
        <?php foreach ($categories as $category) { ?>
            <?php if ($categoryID === $category->id) { ?>
                <div>
                    <a class="category-link" href="category?category_id=<?= $category->id ?>">
                        <p><?= $category->name ?></p>
                    </a>
                </div>
            <?php } ?>
        <?php } ?>
        <div class="category-sort">
        <?php foreach ($models as $model) { ?>
            <?php if ($categoryID === $model['product']['category_id'] || $model['product']['category_id'] == (int)Yii::$app->request->get()['category_id']) { ?>
                <div class="thumbnail category-container">
                    <a class=""
                       href="view?id=<?= $model['product']['id'] ?>&category=<?= $model['product']['category_id'] ?>">
                        <?php if ($model['product']['image'] !== null) { ?>
                            <img
                                src='<?= Yii::getAlias('@frontendUrl') . '/img/miniatures/' . $model['product']['image'] ?>'
                                width="100" height="100" alt="">
                        <?php } else { ?>
                            <img src='<?= Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg' ?>' width="100"
                                 height="100" alt="">
                        <?php } ?>
                        <div>
                            <p class="product-name"><?= $model['product']['name'] ?></p>
                    </a>
                </div>
                </div>
            <?php } ?>
        <?php } ?>
        </div>
    <?php } ?>
    </div>
<?php } ?>

<?php foreach ($_GET as $key => $value) {
    if ($key !== 'page' && $key !== 'per-page' && $key !== 'category_id') {
        foreach ($value as $item) { ?>
            <script> document.getElementById("<?= $item ?>").checked = true </script>
        <?php }
    }
} ?>
