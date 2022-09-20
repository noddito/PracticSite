<?php

use backend\helpers\UsdCourse;
use common\models\Category;
use common\models\Product;
use common\models\search\ProductSearch;
use trntv\yii\datetime\DateTimeWidget;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\LinkPager;

/**
 * @var $this View
 * @var $pages Pagination
 * @var $searchModel ProductSearch
 * @var $dataProvider ActiveDataProvider
 */

$this->title = Yii::t('common', 'Products');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="product-index">
    <p>
        <?= Html::a(Yii::t('backend', 'Create Product'), ['create'], ['class' => 'btn btn-success', 'type' => 'button']) ?>
    </p>
    <div class="pagination">
        <?=
        LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'headerOptions' => ['style' => 'width: 60px;'],
            ],
            [
                'attribute' => 'image',
                'format' => 'html',
                'value' => static function ($model): string {
                    if ($model['image'] !== null) {
                        return Html::img($model->getImage());
                    }

                    return Html::img($model->getStub(), ['width' => '100px', 'height' => '100px']);
                },
            ],

            'name',
            'description',
            'price',
            'price_usd',

            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'phpDatetimeFormat' => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            [
                'attribute' => 'updated_at',
                'format' => 'datetime',
                'filter' => DateTimeWidget::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'phpDatetimeFormat' => 'dd.MM.yyyy',
                    'momentDatetimeFormat' => 'DD.MM.YYYY',
                    'clientEvents' => [
                        'dp.change' => new JsExpression('(e) => $(e.target).find("input").trigger("change.yiiGridView")')
                    ],
                ])
            ],
            [
                'attribute' => 'category_id',
                'value' => static function (Product $model): string {
                    return $model->category->name;
                },
                'filter' => Category::getList(),
            ],

            ['class' => ActionColumn::class],
        ],
    ]);

    echo 'Курс доллара: ' . UsdCourse::getUsdCourse();
    ?>
</div>
