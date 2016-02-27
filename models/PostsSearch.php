<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostsSearch extends Posts {
    /** @var News[] */
    public $news;

    /**
     * Настройка правил фильтрации
     * @return array
     */
    public function rules() {
        return [
            [[ 'news', 'visitor', 'text' ], 'safe']
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    /**
     * Поиск для GridView
     * @param array $params
     * @return mixed
     */
    public function search($params) {
        $query = Posts::find()->joinWith('news');
        $data_provider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 'defaultOrder' => [ 'created_at' => SORT_DESC ]]
        ]);

        $data_provider->sort->attributes['news'] = [
            'asc' => ['news.title' => SORT_ASC],
            'desc' => ['news.title' => SORT_DESC]
        ];

        if (!($this->load($params) && $this->validate())) {
            return $data_provider;
        }

        $query->andFilterWhere([ 'like', 'news.title', $this->news ]);
        $query->andFilterWhere([ 'like', 'posts.text', $this->text ]);
        $query->andFilterWhere([ 'like', 'posts.visitor', $this->visitor ]);

        return $data_provider;
    }
}