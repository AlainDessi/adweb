<?php

namespace Core\Http;

use Alert;

class Session
{

  public function __construct()
  {

    if(!session_id()) {
      session_start();
    }

  }

  public function put($group, $key, $value)
  {
    $_SESSION[$group][$key] = $value;
  }

  public function get($group, $key)
  {
    return $_SESSION[$group][$key];
  }


  public function setMsg($type,$msg)
  {
    $_SESSION['msg'][$type] = $msg;
  }

  public function danger($msg) {
    $this->setMsg('danger',$msg);
  }

  public function warning($msg) {
    $this->setMsg('warning',$msg);
  }

  public function info($msg) {
    $this->setMsg('info',$msg);
  }

  public function success($msg) {
    $this->setMsg('success',$msg);
  }

  public function hasMsg()
  {
    return isset($_SESSION['msg']);
  }

  public function clearMsg()
  {
    unset($_SESSION['msg']);
  }

  public function printMsg()
  {

    $html = '';

    foreach ($_SESSION['msg'] as $key => $value) {
      $html .= Alert::alert($key,$value) . "\n";
    }

    $this->clearMsg();

    return $html;
  }


} // end class
