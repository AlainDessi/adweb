<?php

class RequestTest extends PHPUnit_Framework_TestCase
{
    public function testFacade()
    {
        $json = Request::isJson();
        $this->assertEquals(false, $json);
    }
}
