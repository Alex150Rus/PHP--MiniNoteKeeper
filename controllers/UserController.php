<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 16:40
 */

namespace app\controllers;


use app\models\repositories\UserRepository;
use app\models\User;

class UserController extends Controller
{
  public function actionIndex() {
    echo "здесь может отрисовываться форма, путь - домен/user";
    // создаю нового пользователя с произвольными (сам придумал) данными
    (new UserRepository)->save(new User(null, 'Vasya', '22@ru.ru'));
  }

  public function actionNote() {
    //вот здесь буду ловить id пользователя uri будет /user/note/id=1;

  }

}