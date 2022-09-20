<?php

/**
 * @var $this \yii\web\View
 * @var $content string
 */

use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;

$this->beginContent('@frontend/views/layouts/base.php');

?>

<div>

    <?php if (Yii::$app->session->hasFlash('alert')): ?>
        <?php echo Alert::widget([
            'body' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'body'),
            'options' => ArrayHelper::getValue(Yii::$app->session->getFlash('alert'), 'options'),
        ]) ?>
    <?php endif; ?>

    <?php echo $content ?>

</div>

<?php $this->endContent() ?>
