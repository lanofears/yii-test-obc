<?php

use app\components\html\AdminNavigationHelper;
use yii\helpers\Html;
use yii\bootstrap\Html as BtHtml;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this View */
/* @var $content string */

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
        'brand_label'   => BtHtml::icon('cog').' Администрирование',
        'brand_url'     => '/admin',
        'menu_items'    => AdminNavigationHelper::get()->generateNavItems(isset($this->params['action']) ?
            $this->params['action'] : ''),
    ]) ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links'     => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink'  => false
        ]) ?>
        <?= $content ?>
    </div>
</div>
<?php echo $this->render('_footer') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
