<?php

/* @var $this yii\web\View */
/* @var $model common\models\PropertyAttribute */

$this->title = Yii::t('backend', 'Update Property Attributes: '). $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Property Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('backend', 'Update');
?>

<div class="property-attributes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
