<?php

use Core\Html\HtmlBootstrapForm;

class Form
{

  public static function __callStatic($method,$args)
  {
    $form = new HtmlBootstrapForm();
    return call_user_func_array([$form,$method], $args);
  }

}
