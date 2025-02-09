<?php

use Core\Html\HtmlBootstrap5Form;

class NewForm
{

  public static function __callStatic($method,$args)
  {
    $form = new HtmlBootstrap5Form();
    return call_user_func_array([$form,$method], $args);
  }

}
