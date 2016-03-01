<?php
use app\components\html\LinkHelper;
use app\components\html\SiteNavigationHelper;
use app\components\html\NewsSorter;
use app\models\Categories;
use yii\bootstrap\Html as BtHtml;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var Categories $category */
/* @var ActiveDataProvider $data_provider  */

$this->title = Yii::$app->params['brandName'].' | '.$category->name;
$this->params['category'] = $category;
$this->params['breadcrumbs'] = SiteNavigationHelper::get()->generateBreadcrumbs($category);
$child_categories = SiteNavigationHelper::get()->getChildCategories($category);

?>
<div>
    <h1 class="category-name"><span style="font-size: 75%;"><?= BtHtml::icon('menu-right') ?></span><?= $category->name ?></h1>
    <h5>
    <?php foreach ($child_categories as $sub_category): ?>
        <?= LinkHelper::category_link($sub_category, [ 'class' => 'btn btn-link' ]) ?>
    <?php endforeach; ?>
    </h5>
</div>
<?php
Pjax::begin([
    'timeout' => 50000,
]);

echo ListView::widget([
    'dataProvider' => $data_provider,
    'options' => [
        'tag' => 'div',
        'class' => 'list-wrapper',
    ],
    'layout' => "{sorter}\n{items}\n{pager}",
    'itemView' => function ($model) {
        return $this->render('_news_item',[ 'model' => $model ]);
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
