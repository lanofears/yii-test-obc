<?php

namespace app\models;

use app\components\text\TextHelper;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель рновостных разделов
 * @package app\models
 */
class Categories extends ActiveRecord {
    public static function tableName() {
        return 'categories';
    }

    /**
     * Настройка дополнительных обработчиков для модели
     * @return array
     */
    public function behaviors() {
        return [[
                    'class'                 => TimestampBehavior::className(),
                    'createdAtAttribute'    => 'created_at',
                    'updatedAtAttribute'    => 'updated_at',
                    'value'                 => new Expression('NOW()')
                ],
                [
                    'class'         => AttributeBehavior::className(),
                    'attributes'    => [ ActiveRecord::EVENT_BEFORE_VALIDATE => 'trans_name', ],
                    'value'         => function($event) {
                                           return TextHelper::transliterate($this->name);
                                       }
                ]];
    }

    /**
     * Правила валидации для пользовательского комментария
     * @return array
     */
    public function rules() {
        return [
            [[ 'name' ], 'required' ],
            [[ 'name' ], 'string', 'max' => 100 ],
            [[ 'trans_name' ], 'unique'],
            [[ 'parent_id' ], 'integer'],
            [[ 'parent_id' ] , 'compare',
                    'compareAttribute'  => 'id',
                    'operator'          => '!=',
                    'skipOnEmpty'       => true,
                    'message'           => 'Нельзя устанвоить раздел подразделом самого себя'
            ]
        ];
    }

    /**
     * Привязка к родителькому разделу
     * @return ActiveQuery
     */
    public function getParent() {
        return $this->hasOne(Categories::class, [ 'id' => 'parent_id' ])
            ->from(Categories::tableName().' cp');
    }

    /**
     * Дочернии разделы
     * @return ActiveQuery
     */
    public function getChildren() {
        return $this->hasMany(Categories::class, [ 'parent_id' => 'id' ])
            ->innerJoinWith('news', false)
            ->orderBy('name');
    }

    /**
     * Новости в данном разделе
     * @return ActiveQuery
     */
    public function getNews() {
        return $this->hasMany(News::class, [ 'category_id' => 'id' ]);
    }

    /**
     * Наименования полей
     * @return array
     */
    public function attributeLabels() {
        return [
            'id'            => 'ИД',
            'parent_id'     => 'Основной раздел',
            'parent'        => 'Основной раздел',
            'name'          => 'Наименование',
            'trans_name'    => 'Наименование',
            'created_at'    => 'Дата создания',
            'updated_at'    => 'Дата обновления',
        ];
    }
}