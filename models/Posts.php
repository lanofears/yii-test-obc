<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Класс модели комментария к статье
 * @package app\models
 */
class Posts extends ActiveRecord {
    /** @var string */
    public $verification_code;

    public static function tableName() {
        return 'posts';
    }

    /**
     * Настройка дополнительных обработчиков для модели
     * @return array
     */
    public function behaviors() {
        return [[
             'class'              => TimestampBehavior::className(),
             'createdAtAttribute' => 'created_at',
             'updatedAtAttribute' => false,
             'value'              => new Expression('NOW()')
         ]];
    }
    /**
     * Связь с таблицей новостей
     * @return ActiveQuery
     */
    public function getNews() {
        return $this->hasOne(News::class, [ 'id' => 'news_id' ]);
    }

    /**
     * Правила валидации для пользовательского комментария
     * @return array
     */
    public function rules() {
        return [
            [[ 'visitor', 'text', 'news_id' ], 'required' ],
            [[ 'visitor' ], 'string', 'max' => 30 ],
            [ 'verification_code', 'captcha', 'captchaAction' => '/site/captcha' ],
        ];
    }

    /**
     * Наименования полей
     * @return array
     */
    public function attributeLabels() {
        return [
            'news'              => 'Новость',
            'text'              => 'Комментарий',
            'visitor'           => 'Посетитель',
            'verification_code' => 'Код подтверждения',
            'created_at'        => 'Дата добавления'
        ];
    }
}