<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>

<div class="row" style="margin-top:70px;">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <?php
        $allFlashes = Yii::$app->session->getAllFlashes();
        if (!empty($allFlashes))
        {
            foreach ($allFlashes as $flash)
            { ?>
                <h4 style="border-radius: 10px;"class="<?= $flash['options']['class'] ?>"><?= $flash['body'] ?></h4>
            <?php   }
        }
        ?>
        <div class="panel panel-default">
            <form method="post" action='<?= Url::to(['sign-in/reset-password']); ?>'>
                <div style="margin-left: 10px;"><h3><?= Yii::t('frontend', 'Entering a new password') ?></h3></div>
            <div class="panel-body" >
                <input type="text" class="form-group field-loginform-identity required has-error" name="password" placeholder='<?= Yii::t('frontend', 'Enter new password') ?>''>
                <input type="text" class="form-group field-loginform-identity required has-error" name="password2" placeholder='<?=Yii::t('frontend', 'Repeat new password') ?>'>
                <?= Html::hiddenInput('key', Yii::$app->request->get()['key']); ?>
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken); ?>
                <div><input class="btn btn-success" type="submit" value="<?= Yii::t('common', 'Save') ?>"></div>
            </form>
        </div>
    </div>
</div>

