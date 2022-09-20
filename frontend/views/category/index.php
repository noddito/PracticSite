<?php

use common\models\Category;
use yii\helpers\Html;

/**
 * @var $categories Category
 */

?>
<div>
    <div class="category-list">
        <?php foreach ($categories as $category) { ?>
            <form method="post" class="category">
                <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken); ?>
                <?= Html::hiddenInput('category_id', $category['id']); ?>
                <?= Html::hiddenInput('parent_id', $category['parent_id']); ?>
                <input type="submit" value="<?=$category['name']?>">
            </form>
       <?php } ?>
    </div>
</div>



