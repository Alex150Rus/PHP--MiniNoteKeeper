<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 15:51
 */

namespace app\services;


class Request
{
  protected $requestString;
  protected $controllerName;
  protected $actionName;
  protected $params;
  protected $httpreferrer;
  protected $pattern = '#(?P<controller>\w+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui';

  public function __construct()
  {
    $this->requestString = $_SERVER['REQUEST_URI'];
    $this->parseRequest();
  }

  public function parseRequest()
  {
    if (preg_match_all($this->pattern, $this->requestString, $matches)) {
      $this->controllerName = $matches['controller'][0];
      $this->actionName = $matches['action'][0];
      $this->params = $_REQUEST;
    };
  }

  public function getControllerName()
  {
    return $this->controllerName;
  }

  public function getActionName()
  {
    return $this->actionName;
  }

  public function getParams()
  {
    return $this->params;
  }

  public function getHttpReferrer()
  {
    $this->httpreferrer = $_SERVER['HTTP_REFERER'];
    return header("Location: $this->httpreferrer");
  }
}