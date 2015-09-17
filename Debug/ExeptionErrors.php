<?php

namespace Core\Debug;

class ExeptionErrors extends Errors
{

  public function __construct($e)
  {
    $this->message = $e->getMessage();
    $this->code = $e->getCode();
    $this->file = $e->getFile();
    $this->line = $e->getLine();
    $this->content = $e;

    $this->error = "[Error $this->code ]";
  }


} // end class
