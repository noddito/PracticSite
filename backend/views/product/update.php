<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */

$this->title = Yii::t('backend', 'Update product') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Updating');

?>

<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
