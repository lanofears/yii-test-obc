НОВОСТНОЙ САЙТ-ВИЗИТКА 
======================

ОПИСАНИЕ
--------

На главной странице выводятся 3 новости (отображаем заголовок, краткий текст) отсортированных по дате добавления, с постраничной отрисовкой и возможностью сортировки по дате в прямом и обратном порядке. 
Выводятся только активные новости. В качестве меню используется список категорий в которых есть новости. Вложенность категорий не ограничена.

Для главного меню намеренно не использовался вариант с бесконечно вложенными DropDown'ами, т.к. это вариант не очень удобен в использовании.
Вместо этого отображается единый список подразделов, входящих в основной раздел. Вложенность разделов отображается в виде отступа с точкой.
 
Страница администрирования доступна по адресу: /admin. 
Для входа необходимо использовать следующие идентификационные данные:
Логин - login, пароль - password

Функции доступные в разделе администрирования:
1) Просматривать список новостей, добавлять/редактировать/удалять новость.
2) Просматривать список категорий, добавлять/редактировать/удалять категорию.
3) Удалять комментарии посетителей к новостным статьям

ТРЕБОВАНИЯ
----------

PHP 5.4+: php-pdo, php-pgsql, php-gd с поддержкой PNG, или php-imagick с поддержкой TrueType; 
PostgreSQL;


УСТАНОВКА
---------

### Установка composer (опционально)

Для установки composer на Linux и Mac воспользуйтесь следующими коммандами:

~~~
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
~~~

Для установки composer'а на других системах следуйте инструкциям на сайте [getcomposer.org](https://getcomposer.org/download/)

Скачиваем с github код проекта

~~~
git clone https://github.com/lanofears/yii-test-obc.git $project_folder$
~~~

Устанавливаем с помощью composer зависимости

~~~
composer install
~~~

### Первоначальная настройка БД

Чтобы создать пользователя БД (необходимого для работы приложения) и рабочую схему необходимо выполнить на сервере БД SQL скрипт:   

```sql
CREATE DATABASE websrv;
CREATE USER webserver WITH password 'test';
GRANT ALL privileges ON DATABASE websrv TO webserver;
```

### Создание структуры БД и тестового наполнения

Для создания структуры БД и наполнения ее начальными данными для тестирования необходимо применить миграции

~~~
php yii migrate
~~~


### Создание структуры БД и тестового наполнения

~~~
php yii serve
~~~

