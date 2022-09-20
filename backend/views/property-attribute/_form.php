<?php

use common\models\VariableProperty;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\PropertyAttribute */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="property-attributes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'property_id')->widget(Select2::class, config: [
        'data' => VariableProperty::getVariablePropertiesMap(),
        'options' => ['placeholder' => 'Select variable property'],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ])->label(Yii::t('common', 'Variable Property'));
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
