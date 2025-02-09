<?php

namespace Core\Exceptions;

class DatabaseException extends \Exception
{

  public function __construct($message=NULL, $code=0)
  {
     parent::__construct($message, $code);
  }

} // End class
