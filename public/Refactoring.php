<?php

// задача рефакторинга

class UserRepository
{
  protected $connection = null;

  private function getConnection() {
    if ($this->connection) {
      return $this->connection;
    } else {
      $this->connection = new PDO('mysql:dbname=database;host=localhost', 'admin', 'admin');
    }
  }

  private function getSql($status, $columnName, $columnAmount) {
    return "SELECT * FROM users WHERE status ='$status' AND  {$columnName} = '" . $columnAmount . "'";
  }

  public function getUsersByName($user_name)
  {
    $pdo = $this->getConnection();
    return $pdo->query($this->getSql('a', 'user_name',  $user_name))->fetchAll();
  }

  public function getUsers_by_name($name)
  {
    return $this->getUsersByName($name);
  }

  public function getUsers($email, $user_name, $user_id)
  {
    $pdo = $this->getConnection();;

    return array_merge($pdo->query($this->getSql('a', 'email', $email))->fetchAll(),
      $this->getUsersByName($user_name)->fetchAll(),
      $pdo->query($this->getSql('a', 'user_id', $user_id))->fetchAll());
  }

}
// Пример взаимодействия с классом
//$user = new UserRepository();
//$user->getUsersByName('Alexey');
//$user->getUsers_by_name('Fred');
//$user->getUsers('test@oborot.ru', 'Alexey', 32);


/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 03.02.2019
 * Time: 21:32
 */