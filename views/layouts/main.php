<?php

use app\components\html\SiteNavigationHelper;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\web\View;
use yii\widgets\Breadcrumbs;

/* @var $this View */
/* @var $content string */

$this->title = Yii::$app->params['brandName'].' | Главная страница';
AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php echo $this->render('_main_menu', [
        'brand_label' => Yii::$app->params['brandLabel'],
        'brand_url' => Yii::$app->homeUrl,
        'menu_items' => SiteNavigationHelper::get()->generateNavItems(isset($this->params['category']) ? $this->params['category'] : null),
    ]) ?>
    <?= isset($this->params['jumbotron']) ? $this->params['jumbotron'] : '' ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php echo $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
