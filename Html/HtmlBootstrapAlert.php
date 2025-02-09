<?php

namespace Core\Html;

use Button;

class HtmlBootstrapAlert extends Html
{

  public function __construct()
  {

  }

  public function alert($type,$msg)
  {

    $html  = "<div class=\"alert alert-$type\">\n";
    $html .= "  <p>$msg</p>\n";
    $html .= "</div>";

    return $html;
  }

  public function danger($msg)
  {
    return $this->alert('danger', $msg);
  }

  public function success($msg)
  {
    return $this->alert('success', $msg);
  }

  public function warning($msg)
  {
    return $this->alert('warning', $msg);
  }

  public function info($msg)
  {
    return $this->alert('info', $msg);
  }

} // endclass
