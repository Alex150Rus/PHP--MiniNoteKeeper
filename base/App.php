<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 14:11
 */

namespace app\base;

use app\traits\TSingleton;

class App
{
  use TSingleton;
  public $config;
  public $components;

  public static function call()
  {
    return static::getInstance();
  }

  public function run($config)
  {
    $this->config = $config;
    $this->components = new Storage();
    $this->runController();
  }

  public function runController()
  {
    $controllerName = App::call()->request->getControllerName() ?: $this->config['defaultController'];
    var_dump($controllerName);
    $actionName = App::call()->request->getActionName();
    $controllerClass = $this->config['controllerNamespace'] . ucfirst($controllerName) . "Controller";
    $defaultControllerClass = $this->config['controllerNamespace'] . ucfirst($this->config['defaultController']) . "Controller";
    if (class_exists($controllerClass)) {
      $controller = new $controllerClass();
      $controller->runAction($actionName);
    } else {
      $controller = new $defaultControllerClass();
      $controller->runAction($actionName);
    }
  }

  public function createComponent($name)
  {
    if ($params = $this->config['components'][$name]) {
      $class = $params['class'];
      var_dump($name);
      var_dump($class);
      if (class_exists($class)) {
        unset($params['class']);
        $reflection = new \ReflectionClass($class);
        return $reflection->newInstanceArgs($params);
      }
      throw new \Exception("Не определён класс компонента");
    }
    throw new \Exception("Компонент {$name} не найден");
  }

  public function __get($name)
  {
    return $this->components->get($name);
  }
}