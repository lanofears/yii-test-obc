<?php

namespace app\components\html;

use app\models\Categories;

/**
 * Класс хелпер для генерации выпадающих списков (загуржает все разделы, в том числе и пустые)
 * @package app\components\html
 */
class DropDownHelper {
    /** @var Categories[][] */
    private $categories_by_parent = [];

    /** @var DropDownHelper */
    public static $_instance = null;

    /**
     * Получение доступа к экземпляру класса
     * @return DropDownHelper
     */
    public static function get() {
        if (is_null(self::$_instance)) {
            self::$_instance = new DropDownHelper();
        }

        return self::$_instance;
    }

    /**
     * Конструктор класс, получает модель и формирует внутренний массив разделов
     */
    private function __construct() {
        $categories = Categories::find()->all();

        foreach ($categories as $category) {
            $parent_index = is_null($category->parent_id) ? 0 : $category->parent_id;
            $this->categories_by_parent[$parent_index][$category->id] = $category;
        }
    }

    /**
     * Генерация выпадающего списка с разделами новостей
     * @return array
     */
    public function generateDropDown() {
        $main_categories = isset($this->categories_by_parent[0]) ? $this->categories_by_parent[0] : [];
        if (!$main_categories) {
            return [];
        }

        return $this->_gen_dropdown_items($main_categories, 0);
    }

    /**
     * Генерация элементов для выпадающего списка разделов
     * @param Categories[] $categories Новостной раздел
     * @param int $level Уровень вложенности дочерних элементов меню
     * @return array
     */
    private function _gen_dropdown_items($categories, $level) {
        $items = [];
        foreach ($categories as $category) {
            $items[$category->id] = str_repeat('-', $level).' '.$category->name;

            /** @var Categories[] $child_categories */
            $child_categories = isset($this->categories_by_parent[$category->id]) ?
                $this->categories_by_parent[$category->id] : [];
            if (!$child_categories) {
                continue;
            }

            $next_level = $level + 1;
            $items += $this->_gen_dropdown_items($child_categories, $next_level);
        }

        return $items;
    }
}