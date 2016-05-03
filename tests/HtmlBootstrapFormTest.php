<?php

class HtmlBootstrapFormTest extends PHPUnit_Framework_TestCase
{
    public function testHidden()
    {
        $expected = '<div class="form-group"><input type="hidden" name="content" id="content" class="form-control"/></div>';
        $result = Form::hidden('content');
        $this->assertEquals($expected, $result);
    }

    public function testText()
    {
        $expected = '<div class="form-group"><label for="content">test</label><input type="text" name="content" id="content" class="form-control"/></div>';
        $result = Form::text('test', 'content');
        $this->assertEquals($expected, $result);
    }
}
