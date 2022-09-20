<?php

/* @var $this yii\web\View */
/* @var $model common\models\Status */

$this->title = Yii::t('common', 'Update Status: ') . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('common', 'Update');
?>
<div class="status-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
