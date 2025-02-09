<?php

use Core\Html\HtmlBootstrapMenu;

class Menu
{

  public static function __callStatic($method,$args)
  {
    $form = new HtmlBootstrapMenu();
    return call_user_func_array([$form,$method], $args);
  }

}
