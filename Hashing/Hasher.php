<?php

namespace Core\Hashing;

class Hasher
{

  /**
   * Crypter un mot de passe
   * @param string $string
   */
  public function Encrypt($string)
  {
      return password_hash($string, PASSWORD_BCRYPT);
  }

  /**
   * Verifier un mot de passe crypter
   * @param [type] $string [description]
   * @param [type] $hash   [description]
   */
  public function Check($string,$hash)
  {
      return password_verify($string,$hash);
  }

} // End class
