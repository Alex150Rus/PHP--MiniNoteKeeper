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
    echo "Привет. Этот проект - задание на должность PHP разработчика. Это главная страница.<br>
          - здесь может отрисовываться форма, но задача была другая. 
          Путь - корневой каталог или (корневой каталог)домен/user или любой путь<br> 
          так как Index Отрисовывается по дефолту. могу сделать по-другому, если нужно.
          но в данный момент создаётся пользователь Vasya, который сразу отправляется в БД. Смотри код.<br><br>
          actionIndex -> создаёт пользователя<br><br>
          actionNote -> создаёт статью, при этом id пользователя берётся из uri, а title, content статьи<br>
          предполагается получать методом POST. У меня они генерируются случайным образом в виде чисел,<br>
          путём введения следующей строки uri в браузере: user/note?id=1 (id – это id юзера). Также здесь выводится,<br>
          список заметок от пользователя по его id<br><br>
          actionAdditional-> user/additional (выведет  количество заметок для каждого пользователя в базе данных) и<br>
          выдаст id записей с совпадающими заголовками (title)
          ";
    // создаю нового пользователя с произвольными (сам придумал) данными
    (new UserRepository)->save(new User(null, 'Vasya', '22@ru.ru'));
  }

  public function actionNote()
  {
    //из uri - получу id пользователя;
    // (user/note?id=1) - введу вручную и у меня выполнится скрипт от имени моего Васи,
    //также я могу здесь поменять id - Вась у меня много создалось (ведь на index я часто вхожу)
    $user_id = App::call()->request->getParams();
    // название статьи, контент, скорее всего, придут методом POST
    // я их задам здесь произвольно (вручную) случайным образом (цифрами)
    // но в реальности я бы получал их из класса реквест с проверкой if (!isset($POST))
    $_POST['title'] = mt_rand(1, 100);
    $_POST['content'] = mt_rand(100, 10000);
    $_POST['date_create'] = date(DATE_RSS);

    echo "user_id={$user_id['id']},
     title={$_POST['title']},
      content = {$_POST['content']} ,
       date_create = {$_POST['date_create']}<br>";

    (new NoteRepository)->save(
      new Note(null, $_POST['title'], $_POST['content'], $_POST['date_create'], $user_id['id'])
    );

    // выведу список заметок от пользователя
    $notesObjects = (new NoteRepository())->getAllById($user_id['id']);
   $str = "записи пользователья с id: {$user_id['id']}<br>";
    foreach ($notesObjects as $key => $value) {
      $str .= " Название: {$notesObjects[$key]->title}, 
      текст: {$notesObjects[$key]->content},
       дата создания: {$notesObjects[$key]->date_create}<br>";
    }
    echo $str;
  }

  public function actionAdditional()
  {
    // Можно чисто SQLом SELECT COUNT id from users. потом в цикле SELECT COUNT id FROM notes WHERE user_id = $id из цикла
    // см. ниже
    $userQuantity = count((new UserRepository())->getAll());
    echo "В системе зарегестрированно - $userQuantity пользователей<br><hr>";

    $NoteRepository = new NoteRepository();
    for ($id = 1; $id <= $userQuantity; $id++) {
      $notesQuantity = count($NoteRepository->getAllById($id));
      echo "У пользователя c id = $id всего $notesQuantity заметок<br>";
    }

    $notDistinct = (new NoteRepository())->getAllNotDistinct();
    $str = "id записей с повторяющимися заголовками:";
    foreach ($notDistinct as $key => $value) {
      $str .= " {$notDistinct[$key]->id}, ";
    }
    echo $str;

    // по - другому вычисляю количество пользователей: с помощью sql запроса
    $countUsers =(new UserRepository) ->Count();
    echo "<br><hr>В системе зарегестрированно - $countUsers пользователей<br><hr>";

    //циклом кидаю id
    for ($id = 1; $id <= $countUsers; $id++) {
      echo "У пользователя c id = $id всего {$NoteRepository->CountWhere($id)} заметок<br>";
    }
  }
}