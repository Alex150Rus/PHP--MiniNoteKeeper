<?php
/**
 * Created by PhpStorm.
 * User: Alex1
 * Date: 31.01.2019
 * Time: 16:01
 */

namespace app\models\repositories;


class Note extends Repository
{
  public function getTableName()
  {
    return 'notes';
  }
  function getRecordClass()
  {
    return Note::class;
  }
}