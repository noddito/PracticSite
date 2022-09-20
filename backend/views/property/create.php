<?php

/**
 * @var $this yii\web\View
 * @var $model common\models\Tag
 */

$this->title = Yii::t('backend', 'Create Product Properties');
$this->params['breadcrumbs'][] = ['label' => Yii::t('common', 'Product Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="tag-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
