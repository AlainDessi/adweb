<?php

use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testFacade()
    {
        $json = Request::isJson();
        $this->assertEquals(false, $json);
    }
}
