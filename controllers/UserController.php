<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 16:40
 */

namespace app\controllers;


use app\base\App;
use app\models\repositories\UserRepository;
use app\models\repositories\NoteRepository;
use app\models\User;
use app\models\Note;

class UserController extends Controller
{
  public function actionIndex()
  {
    echo "здесь может отрисовываться форма, путь - домен/user";
    // создаю нового пользователя с произвольными (сам придумал) данными
    (new UserRepository)->save(new User(null, 'Vasya', '22@ru.ru'));
  }

  public function actionNote()
  {
    //из uri - получу id пользователя; (user/note?id=1) - введу вручную и у меня выполнится скрипт от имени моего Васи,
    //также я могу здесь поменять id - Вась у меня много создалось (ведь на index я часто вхожу)
    $user_id = App::call()->request->getParams();
    // название статьи, контент, скорее всего придут методом POST
    // я их задам здесь произвольно (вручную) случайным образом (цифрами)
    $_POST['title'] = mt_rand(1, 100);
    $_POST['content'] = mt_rand(100, 10000);
    $_POST['date_create'] = date(DATE_RSS);

    echo "user_id={$user_id['id']},
     title={$_POST['title']},
      content = {$_POST['content']} ,
       date_create = {$_POST['date_create']}";

    (new NoteRepository)->save(
      new Note(null, $_POST['title'], $_POST['content'], $_POST['date_create'], $user_id['id'])
    );

    // выведу список заметок от пользователя

    var_dump((new NoteRepository())->getAllById($user_id['id']));;
  }

  public function actionAdditional()
  {
    // Можно чисто SQLом SELECT COUNT id from users. потом в цикле SELECT COUNT id FROM notes WHERE user_id = $id из цикла

    $userQuantity =count((new UserRepository())->getAll());
    echo "В системе зарегистрированно - $userQuantity пользователей<br><hr>";
    for ($id=1; $id<=$userQuantity; $id++) {
      $notesQuantity =count((new NoteRepository())->getAllById($id));
      echo "У пользователя c id = $id всего $notesQuantity заметок<br>";
    }

    $notDistinct = (new NoteRepository()) ->getAllNotDistinct();
    var_dump($notDistinct);
  }

  // решим дополнительную задачу посредством sql запросов
  public function actionSql() {

  }

}