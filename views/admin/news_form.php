<?php
use app\components\html\AdminNavigationHelper;
use app\models\News;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/* @var News $model */
/* @var View $this  */
/* @var array $categories */
/* @var array $errors */
/* @var string $action */

$this->title = AdminNavigationHelper::get()->getTitle($action, Yii::$app->params['brandName']);
$this->params['action'] = $action;
$this->params['breadcrumbs'] = AdminNavigationHelper::get()->generateBreadcrumbs($action);
?>

<h1 class="page-header"><?= $this->title ?></h1>
<?php echo $this->render('_error_block', [ 'errors' => $errors ]) ?>
<div class="site-form">
    <?php $form = ActiveForm::begin([
        'id' => 'news-form',
        'options' => [ 'class' => 'form-horizontal' ],
    ]); ?>
    <div class="row">
        <?= $form->field($model, 'category_id', [ 'options' => [ 'class' => 'col-lg-4' ]])->dropDownList($categories); ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'title', [ 'options' => [ 'class' => 'col-lg-12' ]])->textInput(); ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'preview', [ 'options' => [ 'class' => 'col-lg-12' ]])->textarea([ 'rows' => 5 ]); ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'text', [ 'options' => [ 'class' => 'col-lg-12' ]])->textarea([ 'rows' => 12 ]); ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'is_active', [ 'options' => [ 'class' => 'col-lg-6' ]])->checkbox([], false); ?>
    </div>
    <div class="form-group" style="padding-top: 15px;">
        <div class="col-sm-10">
            <?= Html::submitButton('Сохранить', [ 'class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
