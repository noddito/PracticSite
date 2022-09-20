<?php

use yii\helpers\Html;
use yii\helpers\Url; ?>

<div class="row post-container">
    <div class="">
        <form method="post" action="<?= Url::to(['post-service/post']); ?>" name="form" class="post-form-container">
            <input name="recipient" type="text" placeholder="Почта получателя" value="oursupport@gmail.com"/>
            <input name="topic" type="text" placeholder="Тема" />
            <textarea  name="text" cols="32" rows="5"></textarea>
            <?=
            Html::hiddenInput(
                Yii::$app->request->csrfParam,
                Yii::$app->request->csrfToken
            );
            ?>
            <input type="submit" value="Отправить" />
        </form>
    </div>
</div>
