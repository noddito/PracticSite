<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\UserOrder */

$this->title = Yii::t('frontend', 'Order №') . $model->order_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'User Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>
<div class="user-order-view">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'order_id',
            'user_id',
            'description:ntext',
            'total_price',
        ],
    ]) ?>

    <?php echo Html::a(Yii::t('backend', 'Update'), ['update', 'id' => $model->order_id], ['class' => 'btn btn-primary']) ?>
    <?php echo Html::a(Yii::t('backend', 'Delete'), ['delete', 'id' => $model->order_id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => Yii::t('backend', 'Are you sure you want to delete this item?'),
            'method' => 'post',
        ],
    ]) ?>
</div>
