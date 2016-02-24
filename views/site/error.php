<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = 'Ошибка';
$this->params['breadcrumbs'] = [ $this->title ];
$this->params['jumbotron'] = '';
?>
<div class="site-error">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <div>Во время обработки вашего запроса возникла ошибка:</div>
        <strong><?= nl2br(Html::encode($message)) ?></strong>
        <div class="error-footer">Приносим свои извинения</div>
    </div>
</div>
