<?php

/* @var $this yii\web\View */
/* @var $model common\models\VariableProperty */

$this->title = Yii::t('backend', 'Create Variable Properties');
$this->params['breadcrumbs'][] = ['label' => 'Variable Property', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="variable-property-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
