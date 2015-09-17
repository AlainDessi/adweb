<?php

use Core\Html\HtmlHeader;

class Head
{

  public static function __callStatic($method,$args)
  {
    $instance = new HtmlHtmlHeader();
    return call_user_func_array([$form,$instance], $args);
  }

}
