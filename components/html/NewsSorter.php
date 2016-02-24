<?php

namespace app\components\html;

use yii\helpers\Html;
use yii\widgets\LinkSorter;

class NewsSorter extends LinkSorter {
    protected function renderSortLinks() {
        $attributes = empty($this->attributes) ? array_keys($this->sort->attributes) : $this->attributes;
        $links = "";
        $class = "btn btn-primary";

        $this->linkOptions['class'] = isset($this->linkOptions['class']) ? $this->linkOptions['class']." ".$class : $class;
        foreach ($attributes as $name) {
            $links .= $this->sort->link($name, $this->linkOptions);
        }

        return Html::tag('div', Html::tag('h2', 'Последние новости '.$links), [ 'class' => 'page-header' ]);
    }
}