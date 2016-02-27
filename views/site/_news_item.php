<?php
use app\components\html\LinkHelper;
use app\models\News;
use yii\helpers\Html;

/* @var News $model */
?>
<article class="news-item" data-key="<?= $model->id ?>">
    <h3 class="title"><?= Html::encode($model->title) ?></h3>
    <h5 class="text-muted">
        <span>Дата публикации: <?= Yii::$app->formatter->asDate($model->created_at) ?></span>
        <span class="news-category">Раздел: <?= LinkHelper::category_link($model->category, [ 'data-pjax' => '0' ]) ?></span>
    </h5>
    <div class="lead">
        <?= Html::encode($model->preview) ?>
        <?= Html::a('Читать полностью...', '/news/'.$model->trans_title, [ 'class' => 'btn btn-link', 'data-pjax' => '0' ]) ?>
    </div>
</article>