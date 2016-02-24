<?php

use app\components\html\AdminNavigationHelper;
use app\models\Categories;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\ActiveForm;

/* @var Categories $model */
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
        <?= $form->field($model, 'parent_id', [ 'options' => [ 'class' => 'col-lg-4' ]])
            ->dropDownList($categories, [ 'prompt' => '(Раздел не выбран)' ]); ?>
    </div>
    <div class="row">
        <?= $form->field($model, 'name', [ 'options' => [ 'class' => 'col-lg-6' ]])->textInput(); ?>
    </div>
    <div class="form-group" style="padding-top: 15px;">
        <div class="col-sm-10">
            <?= Html::submitButton('Сохранить', [ 'class' => 'btn btn-primary', 'name' => 'submit-button']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
