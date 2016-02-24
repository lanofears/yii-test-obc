<?php

namespace app\commands;

use app\components\html\SiteNavigationHelper;
use app\components\text\TextHelper;
use app\models\Categories;
use yii\console\Controller;

/**
 * Утилита для проверки работы различных элементов сайта
 */
class UtilsController extends Controller {
    /**
     * Проверка работы утилиты для транслитерации текста
     * @param string $text
     */
    public function actionTransliterate($text = '') {
        echo TextHelper::transliterate($text) . "\n";
    }

    /**
     * Вывод всех категорий содержащих в себе новости
     */
    public function actionCategories() {
        $categories = SiteNavigationHelper::get()->getCategories();
        foreach ($categories as $key => $category) {
            echo $key." => [ ".$category->id.", ".$category->name." ]\n";
        }
    }

    /**
     * Вывод всех категорий сгруппированных по родительской категории
     */
    public function actionParents() {
        $categories = SiteNavigationHelper::get()->getCategoriesByParent();
        foreach ($categories as $parent_key => $parent) {
            echo $parent_key." => [\n";
            foreach ($parent as $key => $category) {
                echo "\t".$key . " => [ " . $category->id . ", " . $category->name . " ],\n";
            }
            echo "],\n";
        }
    }

    /**
     * Вывод Breadcrumbs для конкретной категории
     * Указывается идентификатор категории (для вывода все категорий с идентификаторами всопользуйтес
     * коммандой utils/categories)
     * @param $category_id
     */
    public function actionBreadcrumbs($category_id) {
        $category = Categories::findOne($category_id);
        if (!$category) {
            echo 'Не найдена указанная категория';
        }

        $breadcrumbs = SiteNavigationHelper::get()->generateBreadcrumbs($category);
        foreach ($breadcrumbs as $key => $breadcrumb) {
            echo $key." => [ ".(isset($breadcrumb['label']) ?
                    "label => ". $breadcrumb['label'].", url =>". $breadcrumb['url'] :
                    $breadcrumb )." ]\n";
        }
    }
}
