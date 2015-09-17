<?php

namespace Core\Errors;

class HttpErrors {

  public function View($page) {
    echo $blade->view()->make($page)->render();
  }

  public function Error404()
  {
    header('HTTP/1.0 404 Not Found');
    $this->View('404');
  }



} // end class