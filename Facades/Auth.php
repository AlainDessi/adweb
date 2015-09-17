<?php

use Core\Http\SessionAuth as HttpSession;

class Auth
{

  public static function __callStatic($method,$args)
  {
    $session = new HttpSession();
    return call_user_func_array([$session,$method], $args);
  }

}
