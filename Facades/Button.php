<?php

use Core\Html\HtmlBootstrapButton;

class Button
{

  public static function __callStatic($method,$args)
  {
    $form = new HtmlBootstrapButton();
    return call_user_func_array([$form,$method], $args);
  }

}
