<?php

/* @var $this yii\web\View */
/* @var $model common\models\VariableProperty */

$this->title = Yii::t('backend', 'Update Variable Properties: ') . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend','Variable Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend','Update');
?>

<div class="variable-property-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
