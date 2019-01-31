<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 14:49
 */

namespace app\models;

class User
{
 public $id;
 public $name;
 public $email;

 public function __construct($id, $name, $email)
 {
   $this->id = $id;
   $this->name = $name;
   $this->email = $email;
 }
}