<?php

namespace Core\DataBase;

use Core\Config;

class Migration
{

  public function __construct()
  {

  }

  /**
   * [Migrate description]
   * @param [type] $file [description]
   */
  public function Migrate($file)
  {
      $sql = file_get_contents($file);
      $instance = Config::GetDb()->db_open()->exec($sql);
  }

} // end class
