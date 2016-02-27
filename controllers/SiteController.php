<?php

namespace app\controllers;

use app\models\Categories;
use app\models\Posts;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\News;
use yii\web\NotFoundHttpException;
use Yii;

class SiteController extends Controller {
    public function init() {
        parent::init();
        Yii::$app->errorHandler->errorAction = 'site/error';
    }

    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        $data_provider = new ActiveDataProvider([
            'query'         => News::find()->where([ 'is_active' => 1 ]),
            'sort'          => [
                'defaultOrder'  => [ 'created_at' => SORT_DESC ],
                'attributes'    => [ 'asc' => 'created_at' ]
            ],
            'pagination'    => [
                'pageSize'          => 3,
                'defaultPageSize'   => 3
            ]
        ]);

        return $this->render('index', [ 'news_data_provider' => $data_provider ]);
    }

    public function actionNews($title) {
        /** @var News $news */
        $news = News::find()
            ->where([ 'trans_title' => $title ])
            ->andWhere([ 'is_active' => 1 ])
            ->one();
        if (!$news) {
            throw new NotFoundHttpException('Запрашиваемая вами статья отсутствует на сайте');
        }

        $posts_provider = new ActiveDataProvider([
            'query'         => $news->getPosts(),
            'sort'          => [ 'defaultOrder' => [ 'created_at' => SORT_DESC ]],
            'pagination'    => [
                'pageSize'          => 15,
                'defaultPageSize'   => 15
            ]
        ]);

        /** @var Posts $post */
        $post = $news->getNewPost();
        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            $post = $news->getNewPost();
        }
        $errors = $post->errors;

        return $this->render('news', [ 'news_entry' => $news, 'posts_provider' => $posts_provider, 'post' => $post, 'errors' => $errors ]);
    }

    public function actionCategory($name) {
        /** @var Categories $category */
        $category = Categories::find()
            ->innerJoinWith('news', false)
            ->where([ 'trans_name' => $name ])->one();
        if (!$category) {
            throw new NotFoundHttpException('Запрашиваемый вами раздел отсутствует на сайте');
        }

        $data_provider = new ActiveDataProvider([
            'query'         => $category->getNews(),
            'sort'          => [
                'defaultOrder'  => [ 'created_at' => SORT_DESC ],
                'attributes'    => [ 'asc' => 'created_at' ]
            ],
            'pagination'    => [
                'pageSize'          => 5,
                'defaultPageSize'   => 5
            ]
        ]);

        return $this->render('category', [ 'category' => $category, 'data_provider' => $data_provider ]);
    }

    /**
     * Вывод сообщения об ошибке для посетителей сайта
     * @return string
     */
    public function actionError() {
        $exception = Yii::$app->errorHandler->exception;
        $message = $exception ? $exception->getMessage() : 'Неизвестная ощибка сервера';

        return $this->render('error', [ 'message' => $message, 'code' => Yii::$app->response->getStatusCode() ]);
    }
}
