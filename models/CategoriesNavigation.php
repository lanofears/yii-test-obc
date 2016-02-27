<?php

namespace app\models;
use yii\db\ActiveQuery;

/**
 * Модель категорий с дополнительными свояйствами необходимыми для создания навигационных элементов
 */
class CategoriesNavigation extends Categories {
    /** @var int Кол-во новостей в денной категории */
    public $has_news;

    /**
     * Переопределенный метод поиска элементов с добавлением дополнительных полей
     * @return ActiveQuery
     */
    public static function find() {
        return parent::find()
            ->joinWith('news', false)
            ->select([ 'categories.*', 'COUNT(news.id) has_news' ])
            ->groupBy('categories.id')
            ->indexBy('id');
    }
}