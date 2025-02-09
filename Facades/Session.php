<?php

use Core\Http\Session as HttpSession;

class Session
{

  public static function __callStatic($method,$args)
  {
    $session = new HttpSession();
    return call_user_func_array([$session,$method], $args);
  }

}
