<?php

use Core\Http\Request as HttpRequest;

class Request
{

  public static function __callStatic($method,$args)
  {
    $request = new HttpRequest();
    return call_user_func_array([$request,$method], $args);
  }

}