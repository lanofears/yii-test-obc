<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=localhost;dbname=websrv',
    'username' => 'webserver',
    'password' => 'test',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => 'yii\db\pgsql\Schema',
            'defaultSchema' => 'site'
        ]
    ],
    'on afterOpen' => function($event) {
        $event->sender->createCommand('SET search_path TO site')->execute();
    }
];
