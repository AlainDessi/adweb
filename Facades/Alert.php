<?php

use Core\Html\HtmlBootstrapAlert;

class Alert
{

  public static function __callStatic($method,$args)
  {
    $form = new HtmlBootstrapAlert();
    return call_user_func_array([$form,$method], $args);
  }

}
