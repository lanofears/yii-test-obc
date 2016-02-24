<?php

namespace app\components\html;

use yii\helpers\Html;

class AdminNavigationHelper {
    /**
     * Навигационное меню раздела Администрирования
     * @var array
     */
    private $_actions = [
        'admin/news' => [
            'title' => 'Новости', 'url' => '/admin/news',
            'sub_actions' => [
                 'admin/news-update'    => [ 'title' => 'Редактирование новости' ],
                 'admin/news-add'       => [ 'title' => 'Добавление новости' ],
                 'admin/news-delete'    => [ 'title' => 'Удаление новости' ]
            ]
        ],
        'admin/categories' => [
            'title' => 'Разедалы новостей', 'url' => '/admin/categories',
            'sub_actions' => [
                 'admin/categories-update'    => [ 'title' => 'Редактирование раздела' ],
                 'admin/categories-add'       => [ 'title' => 'Добавление раздела' ],
                 'admin/categories-delete'    => [ 'title' => 'Удаление раздела' ]
            ]
        ],
        'admin/posts' => [
            'title' => 'Комментарии посетителей', 'url' => '/admin/posts',
            'sub_actions' => [
                'admin/posts-delete' => [ 'title' => 'Удаление комментария' ]
            ]
        ],
        'admin/logout' => [ 'title' => 'Выход', 'url' => '/admin/logout']
    ];

    /**
     * Кеш для упрощения создания навигационных элементов
     * @var array
     */
    private $_actions_by_id = [];

    /**
     * @var AdminNavigationHelper
     */
    private static $_instance = null;

    /**
     * Конструктор
     */
    private function __construct() {
        foreach ($this->_actions as $action_id => $action) {
            $this->_actions_by_id[$action_id] = [
                'level' => 0,
                'title' => $action['title'],
                'url'   => $action['url']
            ];
            $sub_actions = isset($action['sub_actions']) ? $action['sub_actions'] : [];
            foreach ($sub_actions as $sub_action_id => $sub_action) {
                $this->_actions_by_id[$sub_action_id] = [
                    'level'     => 1,
                    'parent_id' => $action_id,
                    'title'     => $sub_action['title'],
                ];
            }
        }
    }

    /**
     * Получение доступа к экземпляру класса
     * @return AdminNavigationHelper
     */
    public static function get() {
        if (is_null(self::$_instance)) {
            self::$_instance = new AdminNavigationHelper();
        }

        return self::$_instance;
    }

    /**
     * Генерация пунктов главного меню раздела администрирования
     * @param string $current_action
     * @return array
     */
    public function generateNavItems($current_action = '') {
        $parent_action_id = $current_action && isset($this->_actions_by_id[$current_action]['parent_id']) ?
            $this->_actions_by_id[$current_action]['parent_id'] : null;

        $items = [];
        foreach ($this->_actions as $action_id => $action) {
            $item = [ 'label' => $action['title'], 'url' => [ $action['url'] ] ];

            if ($parent_action_id && ($parent_action_id == $action_id)) {
                $item['options'] = [ 'class' => 'active' ];
            }

            $items[] = $item;
        }

        return $items;
    }

    /**
     * Генерация Breadcrumbs на основе полученного идентификатора действия
     * @param string $action
     * @param string[] $default
     * @return array
     */
    public function generateBreadcrumbs($action = '', $default = []) {
        $breadcrumbs = is_array($default) ? $default : [];
        $action = isset($this->_actions_by_id[$action]) ? $this->_actions_by_id[$action] : null;
        if (!$action) {
            return $breadcrumbs;
        }

        while ($action) {
            array_unshift($breadcrumbs, $breadcrumbs ? [
                'label' => Html::encode($action['title']),
                'url' => $action['url']
            ] : Html::encode($action['title']));
            $parent_id = isset($action['parent_id']) ? $action['parent_id'] : '';
            $action = $parent_id && isset($this->_actions_by_id[$parent_id]) ?
                $this->_actions_by_id[$parent_id] : null;
        }

        if ($breadcrumbs) {
            array_unshift($breadcrumbs, [
                'label' => 'Администрирование',
                'url' => '/admin'
            ]);
        }

        return $breadcrumbs;
    }

    /**
     * Получение заголовка странице на основании идентификатора действия
     * @param string $action
     * @param string $header
     * @return string
     */
    public function getTitle($action, $header = '') {
        $action_title = isset($this->_actions_by_id[$action]['title']) ?
            $this->_actions_by_id[$action]['title'] : '';

        if ($header) {
            $title[] = $header;
        }
        $title[] = 'Администрирование';
        if ($action_title) {
            $title[] = $action_title;
        }

        return implode(' | ', $title);
    }
}