<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 16:01
 */

namespace app\models\repositories;


class UserRepository extends Repository
{
  public function getTableName()
  {
    return 'users';
  }
  function getRecordClass()
  {
    return UserRepository::class;
  }
}