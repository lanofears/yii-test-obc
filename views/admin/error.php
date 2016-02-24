<?php

use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $default_message string */
/* @var $exception Exception */

$this->title = 'Ошибка';
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <div>Во время обработки вашего запроса возникла ошибка:</div>
        <?php if (!$exception): ?>
        <strong><?= $default_message ?></strong>
        <?php else: ?>
            <div><?= $exception->getMessage() ?> in <?= $exception->getFile() ?> on line <?= $exception->getLine() ?></div>
            <div><?= nl2br($exception->getTraceAsString()) ?></div>
        <?php endif; ?>
    </div>
</div>
