<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\Tag
 */
$this->title = Yii::t('common', 'Tag Name') . ": " . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Product Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);

?>

<div class="tag-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
        ],
    ]) ?>

    <p>
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this tag?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
</div>
