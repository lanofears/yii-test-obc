<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Модель для формы Аутентификации
 */
class LoginForm extends Model {
    /** @var string */
    public $username;
    /** @var string */
    public $password;
    /** @var bool */
    public $rememberMe = true;

    private $_user = false;

    /**
     * Правила проверки полей модели
     * @return array
     */
    public function rules() {
        return [
            [ [ 'username', 'password' ], 'required' ],
            [ 'rememberMe', 'boolean' ],
            [ 'password', 'validatePassword' ],
        ];
    }

    /**
     * Проверка корректности аутентификационных данных пользователя
     * @param string $attribute Идентификационные данные
     * @param array $params Дополнительные параметры
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Неверные имя пользователя, или пароль');
            }
        }
    }

    /**
     * Авторизация с указанными аутентификационными данными
     * @return boolean Результат аутентификации
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Поиск пользователя по имени
     * @return User|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    /**
     * Наименования полей
     * @return array
     */
    public function attributeLabels() {
        return [
            'username'      => 'Пользователь',
            'password'      => 'Пароль',
            'rememberMe'    => 'Запомнить меня'
        ];
    }
}
