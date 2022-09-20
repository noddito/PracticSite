<?php

/* @var $this yii\web\View */
/* @var $model common\models\UserOrder */

$this->title = Yii::t('backend', 'Create User Order');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-order-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
