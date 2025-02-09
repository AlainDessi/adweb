<?php
use PHPUnit\Framework\TestCase;

class FilesTest extends TestCase
{
    public function testFileInreadDir()
    {
        $files = \Core\Services\Files::readDir(__DIR__ . '/testfiles/');
        $this->assertArraySubset(['0' => __DIR__ . '/testfiles/test.txt'], $files);
    }

    public function testCreateDirectory()
    {
        $directory = \Core\Services\Files::createDir(__DIR__ . '/testfiles/test/');
        $this->assertEquals(__DIR__ . "/testfiles/test/", $directory);
    }

    public function testCreateMultiDirectory()
    {
        $directory = \Core\Services\Files::createDir(__DIR__ . '/testfiles/test/toto/tata');
        $this->assertEquals(__DIR__ . "/testfiles/test/toto/tata", $directory);
    }
}
