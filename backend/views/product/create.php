<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */
$this->title = Yii::t('backend', 'Products');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Create Product'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
