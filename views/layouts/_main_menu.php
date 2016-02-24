<?php

use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var array $menu_items */
/* @var string $brand_label */
/* @var string $brand_url */

NavBar::begin([
    'brandLabel' => $brand_label,
    'brandUrl' => $brand_url,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'encodeLabels' => false,
    'items' => $menu_items,
]);

NavBar::end();
