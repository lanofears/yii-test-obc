<?php

use app\components\html\AdminNavigationHelper;
use app\models\NewsSearch;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var View $this*/
/* @var ActiveDataProvider $posts_provider */
/* @var NewsSearch $posts_search */
/* @var array $posts_columns */
/* @var string $action */

$this->title = AdminNavigationHelper::get()->getTitle($action, Yii::$app->params['brandName']);
$this->params['action'] = $action;
$this->params['breadcrumbs'] = AdminNavigationHelper::get()->generateBreadcrumbs($action);
?>

<h1 class="page-header">Комментарии посетителей</h1>

<?php Pjax::begin() ?>
<?php echo GridView::widget([
    'dataProvider'  => $posts_provider,
    'filterModel'   => $posts_search,
    'columns'       => $posts_columns,
    'layout'        => "{pager}\n{items}\n{pager}",
]) ?>
<?php Pjax::end() ?>
