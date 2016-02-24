<?php

use app\components\html\AdminNavigationHelper;
use app\models\NewsSearch;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var View $this*/
/* @var ActiveDataProvider $news_provider */
/* @var NewsSearch $news_search */
/* @var array $news_columns */
/* @var string $action */

$this->title = AdminNavigationHelper::get()->getTitle($action, Yii::$app->params['brandName']);
$this->params['action'] = $action;
$this->params['breadcrumbs'] = AdminNavigationHelper::get()->generateBreadcrumbs($action);
?>

<h1 class="page-header">Новости <?php echo Html::a('Добавить', '/admin/news/add', [ 'class' => 'btn btn-success' ]) ?></h1>

<?php Pjax::begin() ?>
<?php echo GridView::widget([
    'dataProvider'  => $news_provider,
    'filterModel'   => $news_search,
    'columns'       => $news_columns,
    'layout'        => "{pager}\n{items}\n{pager}",
]) ?>
<?php Pjax::end() ?>
