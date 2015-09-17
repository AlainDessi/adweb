<?php

namespace Core\Http;

class Request
{

  /**
   * return $_POST
   *
   */
  public static function Post()
  {

    foreach ($_POST as $key => $value) {
        $type = gettype($_POST[$key]);

        if( $type === 'string' ) {
          $_POST[$key] = htmlspecialchars($value);
        }

        if( $_POST[$key] === 'on' ) {
          $_POST[$key] = 1;
        }

      }
      return $_POST;
  }

} // end of class
