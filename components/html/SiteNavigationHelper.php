<?php

namespace app\components\html;

use app\models\Categories;
use yii\helpers\Html;
use Yii;

/**
 * Вспомогателльный класс для создании элементов навигации на основе выбранной категории
 * @package app\components\html
 */
class SiteNavigationHelper {
    /** @var Categories[] */
    private $categories = [];
    /** @var Categories[][] */
    private $categories_by_parent = [];

    /** @var SiteNavigationHelper */
    public static $_instance = null;

    /**
     * Получение доступа к экземпляру класса
     * @return SiteNavigationHelper
     */
    public static function get() {
        if (is_null(self::$_instance)) {
            self::$_instance = new SiteNavigationHelper();
        }

        return self::$_instance;
    }

    private function __construct() {
        $categories = Categories::find()
            ->innerJoinWith('news', false)
            ->all();

        foreach ($categories as $category) {
            $parent_index = is_null($category->parent_id) ? 0 : $category->parent_id;
            $this->categories[$category->id] = $category;
            $this->categories_by_parent[$parent_index][$category->id] = $category;
        }
    }

    /**
     * Получение всех загруженных категорий, на основе которых строится навигация сайта
     * @return Categories[]
     */
    public function getCategories() {
        return $this->categories;
    }

    /**
     * Получение всех загруженных категорий, сгруппированных по родительской категории
     * @return Categories[][]
     */
    public function getCategoriesByParent() {
        return $this->categories_by_parent;
    }

    /**
     * Вспомогательный метод для генерации URL для перехода в заданный раздел
     * @param Categories $category
     * @return string
     */
    private function _gen_category_url($category) {
        return '/category/'.urlencode($category->trans_name);
    }

    /**
     * Генерация Breadcrumbs на основе полученной модели
     * В качесвте входного параметра можно передать Category, или News
     * Если передан параметр другого типа - возвращается пустой массив
     * @param Categories $category
     * @param string[] $default
     * @return array
     */
    public function generateBreadcrumbs($category = null, $default = []) {
        $breadcrumbs = is_array($default) ? $default : [];
        if (!$category) {
            return $breadcrumbs;
        }

        while ($category) {
            array_unshift($breadcrumbs, [
                'label' => Html::encode($category->name),
                'url' => $this->_gen_category_url($category)
            ]);
            $category = isset($this->categories[$category->parent_id]) ? $this->categories[$category->parent_id] : null;
        }

        return $breadcrumbs;
    }

    /**
     * Генерация пунктов главного меню сайта
     * Для выделения активным пункта меню, необходимо передать раздел который соответстввует этому пункту,
     * или является его дочерним подразделом
     * @param Categories $category
     * @return array
     */
    public function generateNavItems($category = null) {
        /** @var Categories[] $main_categories */
        $main_categories = isset($this->categories_by_parent[0]) ? $this->categories_by_parent[0] : [];
        if (!$main_categories) {
            return [];
        }

        $active_main_category = $this->_find_main_category($category);
        $items = [];
        foreach ($main_categories as $main_category) {
            $item = [ 'label' => Html::encode($main_category->name), 'url' =>$this->_gen_category_url($main_category) ];
            if ($active_main_category && ($main_category->id == $active_main_category->id)) {
                $item['options'] = [ 'class' => 'active' ];
            }

            $child_items = [];
            $this->_gen_child_items($main_category, 0, $child_items);

            if ($child_items) {
                $item['items'] = $child_items;
                $item['url'] = '#';
            }

            $items[$main_category->id] = $item;
        }

        return $items;
    }

    /**
     * Поиск основного раздела для указанного подраздела, если в качестве параметра передается основной раздел,
     * то функция просто возвращает переданное ей значение
     * @param Categories $category
     * @return Categories
     */
    private function _find_main_category($category) {
        while ($category && $category->parent_id) {
            $category = isset($this->categories[$category->parent_id]) ? $this->categories[$category->parent_id] : null;
        }

        return $category;
    }

    /**
     * Генерация элементов меню для основного раздела
     * @param Categories $category Новостной раздел
     * @param int $level Уровень вложенности дочерних элементов меню
     * @param array $items Элементы меню
     */
    private function _gen_child_items($category, $level, &$items) {
        /** @var Categories[] $child_categories */
        $child_categories = isset($this->categories_by_parent[$category->id]) ?
            $this->categories_by_parent[$category->id] : [];
        if (!$child_categories) {
            return;
        }
        if (!$category->parent_id) {
            $items[] = [ 'label' => 'Основной раздел', 'url' => $this->_gen_category_url($category) ];
            $items[] = '<li role="presentation" class="divider"></li>';
        }

        foreach ($child_categories as $child_category) {
            $items[] = [ 'label' => str_repeat('<span>&#183;</span>', $level).Html::encode($child_category->name), 'url' => $this->_gen_category_url($child_category) ];
            $next_level = $level + 1;
            $this->_gen_child_items($child_category, $next_level, $items);
        }
    }
}