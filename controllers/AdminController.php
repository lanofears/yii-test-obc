<?php

namespace app\controllers;

use app\components\html\DropDownHelper;
use app\models\Categories;
use app\models\CategoriesSearch;
use app\models\LoginForm;
use app\models\News;
use app\models\NewsSearch;
use app\models\Posts;
use app\models\PostsSearch;
use yii\filters\AccessControl;
use yii\helpers\BaseStringHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

/**
 * Контроллер для раздела администрирования сайта
 * @package app\controllers
 */
class AdminController extends Controller {
    public $layout = 'admin';

    public function init() {
        parent::init();
        Yii::$app->errorHandler->errorAction = 'admin/error';
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => [ 'login' ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Страницы авторизации
     * @return string|Response
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('/admin');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/admin');
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Отмена авторизации пользователя и переход на главную страницу сайта
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Открытие основной страницы раздела администрирования
     */
    public function actionHome() {
        return $this->render('home');
    }

    /**
     * Открытие страницы администрирования новостей
     */
    public function actionNews() {
        $search_model = new NewsSearch();
        $data_provider = $search_model->search(Yii::$app->request->get());

        $columns = [[
            'attribute'     => 'category',
            'value'         => 'category.name'
        ],
        'title', 'preview', [
            'attribute'     => 'created_at',
            'format'        => [ 'datetime' ]
        ], [
            'attribute'     => 'is_active',
            'format'        => 'raw',
            'value'         => function($data) {
                                    return $data->is_active ?
                                        '<span class="label label-success">актуальна</span>' :
                                        '<span class="label label-danger">не актуальна</span>';
                               }
        ], [
            'class'         => 'yii\grid\ActionColumn',
            'template'      => '{update} {delete}',
            'urlCreator'    => function ($action, $model) {
                                    return '/admin/news/'.$action.'/'.$model->id;
                               }
        ]];

        return $this->render('news', [
            'news_provider' => $data_provider,
            'news_search'   => $search_model,
            'news_columns'  => $columns,
            'action'        => $this->action->uniqueId,
        ]);
    }

    public function actionNewsUpdate($id) {
        /** @var News $news */
        $news = News::findOne($id);
        if (!$news) {
            throw new NotFoundHttpException('Указанная статья не найдена');
        }

        if ($news->load(Yii::$app->request->post()) && $news->save()) {
            return $this->redirect('/admin/news');
        }
        $errors = $news->errors;

        return $this->render('news_form', [
            'title'         => 'Редактирование новости',
            'errors'        => $errors,
            'model'         => $news,
            'categories'    => DropDownHelper::get()->generateDropDown(),
            'action'        => $this->action->uniqueId,
        ]);
    }

    /**
     * Добавление новой новости
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionNewsAdd() {
        /** @var News $news */
        $news = new News();
        $news->is_active = 1;
        if ($news->load(Yii::$app->request->post()) && $news->save()) {
            return $this->redirect('/admin/news');
        }
        $errors = $news->errors;

        return $this->render('news_form', [
            'title'         => 'Добавление новости',
            'errors'        => $errors,
            'model'         => $news,
            'categories'    => DropDownHelper::get()->generateDropDown(),
            'action'        => $this->action->uniqueId,
        ]);
    }

    /**
     * Удаление выбранной новости
     * @param int $id Идентификатор новости
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionNewsDelete($id) {
        /** @var News $news */
        $news = News::findOne($id);
        if (!$news) {
            throw new NotFoundHttpException('Указанная статья не найдена');
        }
        $news->delete();

        $url = Yii::$app->request->referrer ? Yii::$app->request->referrer : '/admin/news';
        return $this->redirect($url);
    }

    /**
     * Открытие страницы администрирования комментариев посетителей
     */
    public function actionPosts() {
        $search_model = new PostsSearch();
        $data_provider = $search_model->search(Yii::$app->request->get());

        $columns = [[
            'attribute'     => 'news',
            'value'         => 'news.title'
        ], 'visitor', [
            'attribute'     => 'text',
            'value'         => function($data) {
                                   return BaseStringHelper::truncate($data->text, 200, '...', 'UTF-8');
                               }
        ], [
            'attribute'     => 'created_at',
            'format'        => [ 'datetime' ]
        ], [
            'class'         => 'yii\grid\ActionColumn',
            'template'      => '{delete}',
            'urlCreator'    => function ($action, $model) {
                                   return '/admin/posts/'.$action.'/'.$model->id;
                               }
        ]];

        return $this->render('posts', [
            'posts_provider'    => $data_provider,
            'posts_search'      => $search_model,
            'posts_columns'     => $columns,
            'action'            => $this->action->uniqueId,
        ]);
    }

    /**
     * Удаление выбранного комментария
     * @param int $id Идентификатор комментария
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionPostsDelete($id) {
        /** @var Posts $post */
        $post = Posts::findOne($id);
        if (!$post) {
            throw new NotFoundHttpException('Указанный комментарий не найден');
        }
        $post->delete();

        $url = Yii::$app->request->referrer ? Yii::$app->request->referrer : '/admin/posts';
        return $this->redirect($url);
    }

    /**
     * Открытие страницы администрирования разделов новостей
     */
    public function actionCategories() {
        $search_model = new CategoriesSearch();
        $data_provider = $search_model->search(Yii::$app->request->get());

        $columns = [
            [
                'attribute'     => 'parent',
                'value'         => 'parent.name'
            ],
            'name', [
                'attribute'     => 'created_at',
                'format'        => [ 'datetime' ]
            ], [
                'attribute'     => 'updated_at',
                'format'        => [ 'datetime' ]
            ], [
                'class'         => 'yii\grid\ActionColumn',
                'template'      => '{update} {delete}',
                'urlCreator'    => function ($action, $model) {
                                       return '/admin/categories/'.$action.'/'.$model->id;
                                   }
            ]
        ];

        return $this->render('categories', [
            'categories_provider'   => $data_provider,
            'categories_search'     => $search_model,
            'categories_columns'    => $columns,
            'action'                => $this->action->uniqueId,
        ]);
    }

    /**
     * Редактирование выбранного раздела
     * @param $id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionCategoriesUpdate($id) {
        /** @var Categories $category */
        $category = Categories::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('Указанная статья не найдена');
        }

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect('/admin/categories');
        }
        $errors = $category->errors;

        return $this->render('categories_form', [
            'title'         => 'Редактирование раздела',
            'errors'        => $errors,
            'model'         => $category,
            'categories'    => DropDownHelper::get()->generateDropDown(),
            'action'        => $this->action->uniqueId,
        ]);
    }

    /**
     * Добавление нового раздела
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionCategoriesAdd() {
        /** @var Categories $category */
        $category = new Categories();
        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            return $this->redirect('/admin/categories');
        }
        $errors = $category->errors;

        return $this->render('categories_form', [
            'title'         => 'Добавление раздела',
            'errors'        => $errors,
            'model'         => $category,
            'categories'    => DropDownHelper::get()->generateDropDown(),
            'action'        => $this->action->uniqueId,
        ]);
    }

    /**
     * Удаление выбранного раздела
     * @param int $id Идентификатор раздела
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionCategoriesDelete($id) {
        /** @var Categories $category */
        $category = Categories::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('Указанный раздел не найден');
        }
        $category->delete();

        $url = Yii::$app->request->referrer ? Yii::$app->request->referrer : '/admin/categories';
        return $this->redirect($url);
    }

    /**
     * Вывод сообщения об ошибке для администратора
     * @return string
     */
    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;

        return $this->render('error', [
            'exception'         => $exception,
            'default_message'   => 'Неизвестная ощибка сервера'
        ]);
    }
}