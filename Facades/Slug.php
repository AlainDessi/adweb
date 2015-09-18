<?php

use Core\Services\Slugifier;

class Slug
{

  public static function __callStatic($method,$args)
  {
    $form = new Slugifier();
    return call_user_func_array([$form,$method], $args);
  }

}