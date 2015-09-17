<?php

use Core\Hashing\Hasher;

class Hash
{

  public static function __callStatic($method,$args)
  {
    $hash = new Hasher();
    return call_user_func_array([$hash,$method], $args);
  }

}