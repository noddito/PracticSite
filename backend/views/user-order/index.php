<?php

use common\models\Status;
use common\models\User;
use common\models\UserOrder;
use yii\data\Pagination;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/**
 * @var $this yii\web\View
 * @var $searchModel common\models\search\UserOrderSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $pages Pagination
 */

$this->title = Yii::t('backend', 'User Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-order-index">

    <p>
        <?= Html::a(Yii::t('backend', 'Create User Order'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="pagination">
        <?= LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value' => static function (UserOrder $model): string {
                    return $model->user->username;
                },
                'filter' => User::getList(),
            ],
            'order_id',
            'description:text',
            'total_price',
            [
                'attribute' => 'status_id',
                'value' => static function (UserOrder $model): string {
                    return $model->status->status;
                },
                'filter' => Status::getList(),
            ],
            [
                'class' => ActionColumn::class,
                'urlCreator' => function ($action, UserOrder $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'order_id' => $model->order_id]);
                }
            ],
        ],
    ]); ?>


</div>
