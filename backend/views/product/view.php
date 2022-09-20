<?php

use yii\helpers\Html;
use yii\web\YiiAsset;
use yii\widgets\DetailView;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 */
$this->title = Yii::t('common', 'Product Name') . ": " . $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
YiiAsset::register($this);
?>

<div class="product-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'price',
            'price_usd',
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => static function ($data): string {
                    if ($data['image'] !== null) {
                        return Html::img(Yii::getAlias('@frontendUrl') . '/img/miniatures/' . $data['image'],
                            ['width' => '100px', 'height' => '100px']);
                    }

                    return Html::img(Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg',
                        ['width' => '100px', 'height' => '100px']);

                },
            ],
            [
                'attribute' => 'category_id',
                'value' => static function ($model): string {
                    return $model->category->name;
                },
            ],

        ],
    ]) ?>
    <p>
        <?= Html::a(Yii::t('common', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('common', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('common', 'Are you sure you want to delete this product?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
