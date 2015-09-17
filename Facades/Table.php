<?php

use Core\Html\HtmlBootstrapTable;

class Table
{
  public static function __callStatic($method,$args)
  {
      $form = new HtmlBootstrapTable();
      return call_user_func_array([$form,$method], $args);
  }

} // End class
