<?php

use common\models\UserProfile;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var $this yii\web\View
 * @var $model common\models\UserProfile
 * @var $form yii\bootstrap\ActiveForm
 * @var $profile array
 */

$this->title = Yii::t('backend', 'Edit profile')
?>
<?php $image = Yii::getAlias('@frontendUrl') . '/img/user/' . $model['avatar_path'];
if (empty($model['avatar_path'])) {
    $image = Yii::getAlias('@frontendUrl') . '/img/nophoto.jpg';
} ?>
<div>
    <div>
        <img class="user-avatar" src="<?= $image ?>">
    </div>
    <br>
<div class="user-profile-form">

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'avatar_path')->fileInput() ?>

    <?= $form->field($model, 'firstname')->textInput(['maxlength' => 25]) ?>

    <?= $form->field($model, 'middlename')->textInput(['maxlength' => 25]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => 40]) ?>

    <?= $form->field($model, 'locale')->dropDownlist(Yii::$app->params['availableLocales']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'gender')->dropDownlist([
        UserProfile::GENDER_FEMALE => Yii::t('backend', 'Female'),
        UserProfile::GENDER_MALE => Yii::t('backend', 'Male')
    ]) ?>

    <div class="form-group">
        <?php echo Html::submitButton(Yii::t('backend', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>
</div>
