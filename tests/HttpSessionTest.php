<?php

class HttpSessionTest extends PHPUnit_Framework_TestCase
{
    public function testSetValue()
    {
        $session = new Core\Http\Session();
        $value = $session->setValue('group', 'key', 'value');
        $result = $_SESSION['group']['key'];
        $this->assertEquals($value, $result);
    }

    public function testGetGroup()
    {
        $session = new Core\Http\Session();
        $_SESSION['group']['key'] = 'value';
        $expected = $_SESSION['group'];
        $result = $session->get('group');
        $this->assertEquals($expected, $result);
    }

    public function testGetValue()
    {
        $session = new Core\Http\Session();
        $_SESSION['group']['key'] = 'value';
        $expected = $_SESSION['group']['key'];
        $result = $session->get('group', 'key');
        $this->assertEquals($expected, $result);
    }

    public function testUnsetValue()
    {
        $_SESSION['group']['key'] = 'value';
        $session = new Core\Http\Session();
        $session->unsetValue('group', 'key');
        $result = isset($_SESSION['group']['key']);
        $this->assertFalse($result);
    }
}