<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 16:31
 */

namespace app\controllers;


abstract class Controller
{

  protected $action;
  //храним дефолтный экшн
  protected $defaultAction = 'index';

  public function runAction($action = null)
  {
    //записываем текущий экшн, если он передан, если нет - используем дефолтный
    $this->action = $action ?: $this->defaultAction;
    //формируем наименование метода конкатенацией и увеличиваем первую букву
    $method = "action" . ucfirst($this->action);
    if (method_exists($this, $method)) {
      //если метод существет, то запускаем его
      $this->$method();
      //иначе
    } else {
      echo "404";
    }
  }
}