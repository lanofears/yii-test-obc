<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Служебная модель для настроек сортировки и фильтрации при отображении разделв в GridView
 * @package app\models
 */
class CategoriesSearch extends Categories {
    /**
     * Настройка правил фильтрации
     * @return array
     */
    public function rules() {
        return [
            [[ 'name', 'parent' ], 'safe']
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
        $query = Categories::find()->joinWith('parent');
        $data_provider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [ 'defaultOrder' => ['name' => SORT_DESC ]]
        ]);

        $data_provider->sort->attributes['parent'] = [
            'asc' => ['cp.name' => SORT_ASC],
            'desc' => ['cp.name' => SORT_DESC]
        ];

        if (!($this->load($params) && $this->validate())) {
            return $data_provider;
        }

        $query->andFilterWhere([ 'like', 'cp.name', $this->parent ]);
        $query->andFilterWhere([ 'like', 'categories.name', $this->name ]);

        return $data_provider;
    }
}