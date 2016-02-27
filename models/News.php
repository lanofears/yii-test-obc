<?php

namespace app\models;

use app\components\text\TextHelper;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Модель новостных статей
 * @package app\models
 */
class News extends ActiveRecord {
    /**
     * Имя таблицы модели
     * @return string
     */
    public static function tableName() {
        return 'news';
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
            'class' => AttributeBehavior::className(),
            'attributes' => [
                ActiveRecord::EVENT_BEFORE_VALIDATE => 'trans_title',
            ],
            'value' => function() {
                return TextHelper::transliterate($this->title);
            }
        ]];
    }

    /**
     * Правила валидации для пользовательского комментария
     * @return array
     */
    public function rules() {
        return [
            [[ 'title', 'text', 'preview', 'is_active', 'category_id' ], 'required' ],
            [[ 'title' ], 'string', 'max' => 100 ],
            [[ 'trans_title' ], 'unique'],
        ];
    }

    /**
     * Связка с категорией, к которой принадлежит данная новость
     * @return ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(Categories::class, [ 'id' => 'category_id' ]);
    }

    /**
     * Связка с комментариями, к данной новости
     * @return ActiveQuery
     */
    public function getPosts() {
        return $this->hasMany(Posts::class, [ 'news_id' => 'id' ]);
    }

    /**
     * Создание нового комментария для данной новости
     * @return Posts
     */
    public function getNewPost() {
        $post = new Posts();
        $post->news_id = $this->id;
        return $post;
    }

    /**
     * Наименования полей
     * @return array
     */
    public function attributeLabels() {
        return [
            'id'            => 'ИД',
            'category'      => 'Категория',
            'category_id'   => 'Категория',
            'title'         => 'Заголовок',
            'trans_title'   => 'Заголовок',
            'preview'       => 'Анонс',
            'text'          => 'Текст',
            'is_active'     => 'Актуальность',
            'created_at'    => 'Дата публикации',
            'updated_at'    => 'Дата обновления'
        ];
    }
}