<?php

use frontend\modules\user\models\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var $this View
 * @var $form ActiveForm
 * @var $model LoginForm
 */

$this->title = Yii::t('frontend', 'Login');
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
                <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?php echo $form->field($model, 'identity') ?>
                <?php echo $form->field($model, 'password')->passwordInput() ?>
                <?php echo $form->field($model, 'rememberMe')->checkbox() ?>
                <a class="create-account" href="registraion"><?= Yii::t('frontend','I haven`t account'); ?></a>
                <a class="restore-password" href="recovery-pass"><?= Yii::t('frontend','I don`t remember password'); ?></a>
                <div class="form-group btn-login">
                    <?php echo Html::submitButton(Yii::t('frontend', 'Login'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

