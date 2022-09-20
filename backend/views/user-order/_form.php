<?php

use common\models\UserOrder;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserOrder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->widget(Select2::class, [
        'data' => UserOrder::getUserMap(),
        'options' => ['placeholder' => 'Select user'],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]); ?>

    <?= $form->field($model, 'total_price')->textInput() ?>

    <?= $form->field($model, 'status_id')->widget(Select2::class, [
        'data' => UserOrder::getStatusMap(),
        'options' => ['placeholder' => 'Select status'],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
