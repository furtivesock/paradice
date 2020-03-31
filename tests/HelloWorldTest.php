<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class HelloWorldTest extends TestCase
{
    public function testHelloWorld()
    {
        $test = "Hello World!";
        $this->assertEquals("Hello World!", $test);
    }
}
