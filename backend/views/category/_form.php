<?php

use common\models\Category;
use kartik\select2\Select2;
use mihaildev\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $this yii\web\View
 * @var $model common\models\Category
 * @var $form yii\widgets\ActiveForm
 */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="no-search-box">
        <?= $form->field($model, 'parent_id')->widget(Select2::class, [
            'data' => Category::getCategoryMap(),
            'options' => ['placeholder' => 'Select category'],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10,
            ],
        ])->label(Yii::t('backend', 'Select Parent Category'));
        ?>
    </div>

    <?= $form->field($model, 'description')->widget(CKEditor::class, [
        'editorOptions' => [
            'preset' => 'full', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('common', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
