<?php

use app\components\html\NewsSorter;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var ActiveDataProvider $news_data_provider */
/* @var $this View */

$this->title = 'Главная страница';
$this->params['jumbotron'] = $this->render('_jumbotron');
?>
<div class="site-index">
    <div class="body-content">
        <?php
            Pjax::begin();

            echo ListView::widget([
                'dataProvider' => $news_data_provider,
                'options' => [
                    'tag' => 'div',
                    'class' => 'list-wrapper',
                    'id' => 'list-wrapper',
                ],
                'layout' => "{sorter}\n{items}\n{pager}",
                'itemView' => function ($model, $key, $index, $widget) {
                    return $this->render('_news_item',['model' => $model]);
                },
                'itemOptions' => [
                    'tag' => false,
                ],
                'sorter' => [
                    'class' => NewsSorter::class
                ],
                'pager' => [
                    'firstPageLabel' => 'В начало',
                    'lastPageLabel' => 'В конец',
                    'nextPageLabel' => 'Следующая',
                    'prevPageLabel' => 'Предыдущая',
                    'maxButtonCount' => 3,
                ],
            ]);

            Pjax::end();
        ?>
    </div>
</div>
