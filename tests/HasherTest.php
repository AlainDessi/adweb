<?php

class HasherTest extends PHPUnit_Framework_TestCase
{

  public function testIsCheckWithGoodPassword()
  {
    $password = Hash::Encrypt('Alain');
    $this->assertEquals(true, Hash::check('Alain', $password));
  }

  public function testIsCheckWithNoGoodPassword()
  {
    $password = Hash::Encrypt('Toto');
    $this->assertEquals(false, Hash::check('Alain', $password));
  }

}