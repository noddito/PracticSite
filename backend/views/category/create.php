<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 */
$this->title = Yii::t('backend', 'Create Product Category');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Product Category'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="category-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
