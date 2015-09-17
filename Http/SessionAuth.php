<?php

namespace Core\Http;

use App\Model\Rights;
use App\Model\Users;

class SessionAuth extends Session
{

  public function __construct()
  {
      if(!session_id())
      {
          session_start();
      }
  }


  public function setId($UserId)
  {
      $this->put('Auth', 'id', $UserId);
      return $this;
  }

  public function setEmail($Email)
  {
    $this->put('Auth', 'email', $Email);
    return $this;
  }

  public function getId()
  {
    return get('Auth', 'id');
  }

  public function getEmail()
  {
    return get('Auth', 'email');
  }

  public function hasLogged()
  {
    if(isset($_SESSION['Auth'])){
      return true;
    }
    else {
      return false;
    }
  }

  public function check()
  {
    if(!$this->hasLogged()) {
      redirect('login');
    }
  }

  public function logout()
  {
    unset($_SESSION['Auth']);
  }

  public function rightName($right)
  {
    return Rights::getTitle($right);
  }

} // end class
