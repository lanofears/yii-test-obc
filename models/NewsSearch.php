<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Служебная модель для настроек сортировки и фильтрации при отображении разделв в GridView
 */
class NewsSearch extends News {
    /**
     * Настройка правил фильтрации
     * @return array
     */
    public function rules() {
        return [
            [[ 'title', 'category', 'preview' ], 'safe']
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
        $query = News::find()->joinWith('category');
        $data_provider = new ActiveDataProvider([
            'query' => $query,
            'sort'  => [ 'defaultOrder' => [ 'created_at' => SORT_DESC ]]
        ]);

        $data_provider->sort->attributes['category'] = [
            'asc'   => ['categories.name' => SORT_ASC],
            'desc'  => ['categories.name' => SORT_DESC]
        ];

        if (!($this->load($params) && $this->validate())) {
            return $data_provider;
        }

        $query->andFilterWhere([ 'like', 'categories.name', $this->category ]);
        $query->andFilterWhere([ 'like', 'news.title', $this->title ]);
        $query->andFilterWhere([ 'like', 'news.preview', $this->preview ]);

        return $data_provider;
    }
}