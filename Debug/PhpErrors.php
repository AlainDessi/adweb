<?php

namespace Core\Debug;

class PhpErrors extends Errors
{

  public function __construct($e)
  {



    $this->message = $e[1];
    $this->code = $e[0];
    $this->file = $e[2];
    $this->line = $e[3];
    $this->content = debug_backtrace();

    $this->error = "[ " . $this->getStrCode() . " ]";
  }

  public function getStrCode()
  {

    switch ($this->code) {

      case E_USER_ERROR:    return "E_USER_ERROR";
                            break;

      case E_USER_WARNING:  return "E_USER_WARNING";
                            break;

      case E_USER_NOTICE:   return "E_USER_NOTICE";
                            break;

      case E_PARSE:         return "E_PARSE";
                            break;

      default:              return "UNKNOW ERROR";
                            break;
    }

  }

} // end class
