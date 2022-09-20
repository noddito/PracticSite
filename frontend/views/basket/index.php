<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php if (!Yii::$app->user->isGuest) { ?>
<section>
    <div class="container">
        <div class="col-sm-9">
            <h1>Корзина</h1>
            <div id="basket-content">
                <?php if (!empty($basket)): ?>
                    <p class="text-right">
                        <a href="<?= Url::to(['basket/clear']); ?>" class="text-danger">
                            Очистить корзину
                        </a>
                    </p>
                    <div class="table-responsive">
                        <form action="" method="post">
                            <?=
                            Html::hiddenInput(
                                Yii::$app->request->csrfParam,
                                Yii::$app->request->csrfToken
                            );
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Наименование</th>
                                    <th class="cell-count">Кол-во, шт.</th>
                                    <th>Цена, руб.</th>
                                    <th>Сумма, руб.</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($basket['products'] as $id => $item): ?>
                                    <tr class="table-row">
                                        <td class="cell">
                                            <a href="<?= Url::to(['site/view', 'id' => $id]); ?>">
                                                <?= Html::encode($item['name']); ?>
                                            </a>
                                        </td>
                                        <td class="cell-count">
                                            <button type="button" class="glyphicon glyphicon-minus button-minus" id='minus-<?=$id?>'></button>
                                            <?=
                                            Html::input(
                                                'text',
                                                'count[' . $id . ']',
                                                $item['count'],
                                                ['style' => 'text-align: right; width:60px;' , 'id' => $id]);
                                            ?>
                                            <button type="button" class="glyphicon glyphicon-plus button-plus" id='plus-<?=$id?>'></button>
                                        </td>
                                        <td class="text-right"><?= $item['price']; ?></td>
                                        <td class="text-right"><?= $item['price'] * $item['count']; ?></td>
                                        <td>
                                            <a href="<?= Url::to(['basket/remove', 'id' => $id]); ?>"
                                               class="text-danger">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="2" class="text-right">Итого</td>
                                    <td class="text-right"><?= $basket['amount']; ?></td>
                                    <td></td>
                                </tr>
                            </table>
                            <input type="submit" formaction='<?= Url::to(['basket/post']); ?>' class="btn btn-order pull-right" value="Оформить заказ">
                            <input type="submit" formaction='<?= Url::to(['basket/update']); ?>' class="btn btn-count" value="Пересчитать">
                        </form>
                    </div>
                <?php else: ?>
                    <p>Ваша корзина пуста</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
</section>

<?php }
 else { ?>
<div>
    <h1 style="text-align: center; margin-top: 10%;">Для того чтобы оформить заказ требуется войти в аккаунт</h1>
</div>
<?php } ?>
<script>
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains("button-plus")) {
            ++e.target.parentElement.querySelector("input").value;
        } else if (e.target.classList.contains("button-minus") && e.target.parentElement.querySelector("input").value) {
            --e.target.parentElement.querySelector("input").value;
        }
    })
</script>

