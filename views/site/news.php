<?php
use app\components\html\LinkHelper;
use app\components\html\SiteNavigationHelper;
use app\components\text\TextHelper;
use app\models\News;
use app\models\Posts;
use yii\captcha\Captcha;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var News $news_entry */
/* @var Posts $post */
/* @var array $errors */
/* @var ActiveDataProvider $posts_provider */

$this->title = Yii::$app->params['brandName'].' | '.$news_entry->title;
$this->params['category'] = $news_entry->category;
$this->params['breadcrumbs'] = SiteNavigationHelper::get()->generateBreadcrumbs($news_entry, [ $news_entry->title ]);

?>

<h1 class="news-title"><?= Html::encode($news_entry->title) ?></h1>
<h5 class="news-info text-muted">
    <span>Дата публикации: <?= Yii::$app->formatter->asDate($news_entry->created_at) ?></span>
    <span class="news-category">Раздел: <?= LinkHelper::category_link($news_entry->category) ?></span>
</h5>
<div class="lead news-text">
    <?= TextHelper::format_article(Html::encode($news_entry->text)) ?>
</div>
<?php
Pjax::begin([
    'timeout' => 50000,
]);
?>
<h2 class="page-header">Комментарии</h2>
<div class="post-block">
    <?php
    echo ListView::widget([
        'dataProvider' => $posts_provider,
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
        ],
        'layout' => "{pager}\n{items}",
        'itemView' => function ($model) {
            return $this->render('_post_item',[ 'model' => $model ]);
        },
        'itemOptions' => [
            'tag' => false,
        ],
        'pager' => [
            'firstPageLabel' => 'В начало',
            'lastPageLabel' => 'В конец',
            'nextPageLabel' => 'Следующая',
            'prevPageLabel' => 'Предыдущая',
            'maxButtonCount' => 3,
        ],
    ]); ?>
</div>
<?php echo $this->render('_error_block', [ 'errors' => $errors ]) ?>
<div class="site-form">
    <?php $form = ActiveForm::begin([
        'id' => 'post-form',
        'options' => [ 'data-pjax' => true, 'class' => 'form-horizontal' ],
    ]); ?>

    <div class="row">
        <?= $form->field($post, 'text', [ 'options' => [ 'class' => 'col-lg-12' ]])->textarea([ 'rows' => 6 ]); ?>
    </div>
    <div class="row">
        <?= $form->field($post, 'visitor', [ 'options' => [ 'class' => 'col-lg-3' ]])->textInput(); ?>
        <?= $form->field($post, 'verification_code', [ 'options' => [ 'class' => 'col-lg-7' ]])->widget(Captcha::class, [
            'captchaAction' => '/site/captcha',
            'template' => '<div class="row"><div class="col-lg-3">{input}</div><div class="col-lg-3 no-padding">{image}</div></div>'
        ]); ?>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info">
                Чтобы изменить код - нажмите на картинку с кодом подтверждения
            </div>
        </div>
    </div>
    <div class="form-group" style="padding-top: 15px;">
        <div class="col-sm-10">
            <?= Html::submitButton('Комментировать', ['class' => 'btn btn-primary', 'name' => 'post-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Pjax::end(); ?>