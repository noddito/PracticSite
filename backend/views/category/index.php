<?php

use trntv\yii\datetime\DateTimeWidget;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\CategorySearch
 * @var $dataProvider yii\data\ActiveDataProvider
 */
$this->title = Yii::t('common', 'Product Categories');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="category-index">


    <p>
        <?= Html::a(Yii::t('backend', 'Create Product Category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'parent_id',
            'name',
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
            ['class' => ActionColumn::class],


        ],

    ]); ?>


</div>
