<?php

use Core\Routing\Router;

class Routes
{

  /**
   * Instance de Router
   * @var Instance
   */
  private static $instance = null;

  /**
   * Appel statique de Router
   */
  public static function __callStatic($method,$args)
  {
      if(is_null(self::$instance))
      {
          self::$instance = new Router();
      }

      return call_user_func_array([self::$instance, $method], $args);
  }

}