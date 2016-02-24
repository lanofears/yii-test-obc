<?php

use app\components\html\AdminNavigationHelper;
use app\models\CategoriesSearch;
use yii\bootstrap\Html;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\web\View;
use yii\widgets\Pjax;

/* @var View $this*/
/* @var ActiveDataProvider $categories_provider */
/* @var CategoriesSearch $categories_search */
/* @var array $categories_columns */
/* @var string $action */

$this->title = AdminNavigationHelper::get()->getTitle($action, Yii::$app->params['brandName']);
$this->params['action'] = $action;
$this->params['breadcrumbs'] = AdminNavigationHelper::get()->generateBreadcrumbs($action);
?>

<h1 class="page-header">Разделы новостей <?php echo Html::a('Добавить', '/admin/categories/add', [ 'class' => 'btn btn-success' ]) ?></h1>

<?php Pjax::begin() ?>
<?php echo GridView::widget([
    'dataProvider'  => $categories_provider,
    'filterModel'   => $categories_search,
    'columns'       => $categories_columns,
    'layout'        => "{pager}\n{items}\n{pager}",
]) ?>
<?php Pjax::end() ?>
