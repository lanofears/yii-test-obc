<?php

use app\components\html\AdminNavigationHelper;
use yii\helpers\Html;
use yii\web\View;

/* @var View $this */

$this->title = AdminNavigationHelper::get()->getTitle('', Yii::$app->params['brandName']);
?>

<div class="row">
    <div class="col-md-6">
        <h2>Разделы новостей</h2>
        <div class="lead">
            Перейдите на страницу администрирования разделов новостей, для того чтобы получить возможность:
            добавлять, редактировать и удалять разделы
        </div>
        <?= Html::a('Перейти', '/admin/categories', [ 'class' => 'btn btn-primary' ]) ?>
    </div>
    <div class="col-md-6">
        <h2>Новости</h2>
        <div class="lead">
            Перейдите на страницу администрирования новостей, для того чтобы получить возможность:
            добавлять, редактировать и удалять новости, так же переводить новости в раздел неакутальных
        </div>
        <?= Html::a('Перейти', '/admin/news', [ 'class' => 'btn btn-primary' ]) ?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <h2>Комментарии посетителей</h2>
        <div class="lead">
            Перейдите на страницу администрирования комментариев посетитеоей сайта, для того чтобы получить возможность:
            просматривать и удалять комментарии
        </div>
        <?= Html::a('Перейти', '/admin/posts', [ 'class' => 'btn btn-primary' ]) ?>
    </div>
</div>