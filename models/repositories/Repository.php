<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 15:12
 */

namespace app\models\repositories;
use app\base\App;

abstract class Repository
{
  protected $db;

  public function __construct()
  {
    $this->db = $this->getDb();
  }

  public function getOne($id)
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM {$tableName} WHERE id = :id";
    return $this->db->queryObject($sql, $this->getRecordClass(), [":id" => $id])[0];
  }
  public function getAll()
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM {$tableName}";
    return $this->db->queryObject($sql, $this->getRecordClass());
  }

  public function getAllNotDistinct()
  {
    $tableName = $this->getTableName();
    $sql = "SELECT title, id FROM {$tableName} WHERE title IN (SELECT title FROM {$tableName} GROUP BY title HAVING  COUNT(*)>1)";
    return $this->db->queryObject($sql, $this->getRecordClass());
  }

  // Выводит список заметок конкретного пользователя
  public function getAllById($id)
  {
    $tableName = $this->getTableName();
    $sql = "SELECT * FROM {$tableName} WHERE user_id = :id";
    return $this->db->queryObject($sql, $this->getRecordClass(), [":id" => $id]);
  }

  // Создаёт или обновляет заметку от имени пользователя; создаёт нового пользователя, если id пустая
  public function save($record) {
    $id = $record->id;
    if ($id === null) {
      $this->insert($record);
    } elseif ($record != $record->getOne($id)) {
      $objFromDb =$record->getOne($id);
      $params = [];
      $expression = [];
      foreach ($record as $key => $value) {
        foreach ($objFromDb as $dbKey => $dbValue) {
          if ($key == $dbKey && $key!= 'db' && $value !=$dbValue) {
            $params[":{$key}"] = $value;
            $expression[] = "$key = :$key";
          }
        }
      }
      $params[":id"] = $id;
      $this->update($params, $expression);
    }
  }
  function insert($record)
  {
    $params = [];
    $columns = [];
    foreach ($record as $key => $value) {
      if ($key == 'db' ) {
        continue;
      }
      $params[":{$key}"] = $value;
      $columns[] = "`{$key}`";
    }
    $columns = implode(", ", $columns);
    $placeholders = implode(", ", array_keys($params));
    $tableName = $this->getTableName();
    $sql = "INSERT INTO {$tableName} ({$columns}) VALUES ({$placeholders})";
    $this->db->execute($sql, $params);
    $record->id = $this->db->getLastInsertId();
  }
  public function update(array $params, array $expression)
  {
    $tableName = $this->getTableName();
    $expression = implode(", ",array_values($expression));
    $sql = "UPDATE {$tableName} SET {$expression} WHERE id= :id";
    return $this->db->execute($sql, $params);
  }
  public function delete($record)
  {
    $tableName = $this->getTableName();
    $sql = "DELETE FROM {$tableName} WHERE id = :id";
    return $this->db->execute($sql, [":id" => $record->id]);
  }
  protected function getDb(){
    return App::call()->db;
  }
}