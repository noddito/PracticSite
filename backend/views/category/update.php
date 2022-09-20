<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 */
$this->title = Yii::t('common', 'Update Category') . ": " . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Product Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'tag_id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Updating');

?>

<div class="category-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
