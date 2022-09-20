<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Tag
 */
$this->title = Yii::t('common', 'Update Tag') . ': ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Product Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Updating');

?>

<div class="tag-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
