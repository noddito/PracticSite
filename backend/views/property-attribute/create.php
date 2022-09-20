<?php

/* @var $this yii\web\View */
/* @var $model common\models\PropertyAttribute */

$this->title = Yii::t('backend', 'Create Property Attributes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend', 'Property Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="property-attributes-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
