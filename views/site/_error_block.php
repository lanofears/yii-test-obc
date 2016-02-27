<?php

use yii\helpers\Html;

/* @var $errors */
?>
<?php if ($errors): ?>
    <div class="alert alert-danger" role="alert">
        <?php foreach ($errors as $attribute => $attribute_errors): ?>
            <ul>
                <?php foreach ($attribute_errors as $attribute_error): ?>
                    <li><?= Html::encode($attribute_error) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
