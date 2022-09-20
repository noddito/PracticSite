<?php

use frontend\modules\user\models\Registration;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $form ActiveForm
 * @var $model Registration
 */

$this->title = Yii::t('frontend', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row" style="margin-top:70px;">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $allFlashes = Yii::$app->session->getAllFlashes();
                if (!empty($allFlashes))
                {
                    foreach ($allFlashes as $flash)
                    { ?>
                        <h4 style="border-radius: 10px" class="<?= $flash['options']['class'] ?>"><?= $flash['body'] ?></h4>
                    <?php   }
                }
                ?>
                <?php $form = ActiveForm::begin() ?>
                <?php echo $form->field($model, 'username') ?>
                <?php echo $form->field($model, 'email') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group btn-login">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Register'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
