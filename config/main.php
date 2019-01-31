<?php

return [
  'rootDir' => $_SERVER['DOCUMENT_ROOT'] . "/../",
  'controllerNamespace' => 'app\\controllers\\',
  'defaultController' => 'user',

  'components' => [
    'db' => [
      'class' => \app\services\Db::class,
      'driver' => 'mysql',
      'host' => 'localhost',
      'login' => 'root',
      'password' => 'Alex123belka',
      'database' => 'note-keeper',
      'charset' => 'utf8',
    ],

    'request' => [
      'class' => \app\services\Request::class
    ],
  ]
];

/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 13:48
 */