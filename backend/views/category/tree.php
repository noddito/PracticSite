<?php

use common\models\Category;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\CategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('common', 'Category Tree');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="category-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create Product Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $tree = new Category();
    $tree->buildTree(null, 0);
    ?>
</div>
