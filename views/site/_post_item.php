<?php
use app\models\Posts;
use yii\helpers\Html;

/* @var Posts $model */
?>
<div class="post-item">
    <div class="post-text"><?= $model->text ?></div>
    <div class="text-muted">
        <span><?= Html::encode($model->visitor) ?>: <?= Yii::$app->formatter->asDate($model->created_at) ?></span>
    </div>
</div>