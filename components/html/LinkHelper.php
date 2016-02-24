<?php

namespace app\components\html;

use app\models\Categories;
use yii\helpers\Html;
use yii\bootstrap\Html as BtHtml;

/**
 * Вспомогательный класс для отрисовки Html элементов связанных с разделами новостей
 * @package app\components\html
 */
class LinkHelper {
    /**
     * Создание Html разметки для ссылки на раздел\подраздел новостей
     * @param Categories $category
     * @param array $options Опции которые будут добавлены в тэг "a"
     * @return string
     */
    public static function category_link($category, $options = []) {
        return Html::a(BtHtml::icon('tag').' '.$category->name, '/category/'.$category->trans_name, $options);
    }
}