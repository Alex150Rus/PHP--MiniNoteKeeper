<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 14:53
 */

namespace app\models;


class Note
{
  public $id;
  public $title;
  public $content;
  public $date_create;
  public $user_id;

  public function __construct($id, $title, $content, $date_create, $user_id)
  {
    $this->id = $id;
    $this->title = $title;
    $this->content = $content;
    $this->date_create = $date_create;
    $this->user_id = $user_id;
  }
}