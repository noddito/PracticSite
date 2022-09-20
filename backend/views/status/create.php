<?php

/* @var $this yii\web\View */
/* @var $model common\models\Status */

$this->title = Yii::t('backend', 'Create Status');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Status'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="status-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
