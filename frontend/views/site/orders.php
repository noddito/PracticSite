<?php

use yii\widgets\LinkPager;
use yii\data\Pagination;

/**
 * @var $pages Pagination
 */

if (!empty($orders)) { ?>
<?php ksort($statusList); ?>
<div class="order-main-container">
    <?php foreach ($statusList as $key => $status) { ?>
        <div>
            <?php foreach ($orders as $order) { ?>
                <?php if ($key === $order['status_id']) { ?>
                    <?= $status ?>
                    <div class="order-container">
                        <p class="order-title">Order №<?= $order['order_id'] ?></p>
                        <?= $order['description'] ?>
                        <?php next($orders); ?>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <?php } ?>
</div>
<div class="pagination">
    <?= LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
</div>
