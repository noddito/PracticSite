<?php

/* @var $this yii\web\View */
/* @var $model common\models\UserOrder */

$this->title = Yii::t('backend', 'Update User Order: ') . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->order_id, 'url' => ['view', 'order_id' => $model->order_id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>
<div class="user-order-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
