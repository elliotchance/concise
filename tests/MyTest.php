<?php

require_once('vendor/autoload.php');

use Concise\Core\TestCase;

class MyTest extends TestCase
{
    public function testRange()
    {
        $a = ['foo' => 'bar'];
        $this->assertArray($a)->hasKey('bar');
    }
}
