<?php

use common\models\Product;
use common\models\Property;
use common\models\VariableProperty;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\Product
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => [
            'preset' => 'full',
            'inline' => false,
        ],
    ]); ?>

    <?= $form->field($model, 'price')->textInput() ?>

    <?= $form->field($model, 'category_id')->widget(Select2::class, [
        'data' => Product::getCategoryMap(),
        'options' => ['placeholder' => 'Select category'],
        'pluginOptions' => [
            'tags' => true,
            'maximumInputLength' => 10
        ],
    ]);
    ?>
    <?= $form->field($model, 'tagsArray')->widget(Select2::class, [
        'data' => Product::getTagMap(),
        'language' => 'ru',
        'options' => ['placeholder' => Yii::t('backend', 'Select tags'), 'multiple' => true],
        'pluginOptions' => [
            'tags' => true,
            'allowClear' => true,
        ],
    ])->label(Yii::t('backend', 'Tags'));
    ?>

    <?= $form->field($model, 'image')->fileInput() ?>

    <?php
    $Property = Property::find()->all();
    if ($Property !== null) {
        foreach ($Property as $property) {
            echo $form->field($model, 'propertyArray[' . $property->id . ']')
                ->textInput(['value' => $model->showProperties()])->label($property->name);
        }

    }
    ?>

    <?php
    $variableProperty = VariableProperty::find()->select(['id', 'name'])->all();
    if ($variableProperty !== null) {
        foreach ($variableProperty as $property) {
            echo $form->field($model, 'variablePropertyArray[' . $property->id . ']')->widget(Select2::class, [
                'data' => $model->getVariablePropertyMap($property->id),
                'language' => 'ru',
                'options' => ['placeholder' => Yii::t('backend', 'Select attributes'), 'multiple' => true],
                'pluginOptions' => [
                    'tags' => true,
                    'allowClear' => true,
                    'maximumInputLength' => 10
                ],
            ])->label($property->name);
        }
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
