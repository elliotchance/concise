<?php

namespace Concise\Console;

use \Concise\TestCase;

class ResultPrinterProxy extends TestCase
{
    public function testProxyExtendsPHPUnit()
    {
        $this->assert(new ResultPrinterProxy(), instance_of, 'PHPUnit_TextUI_ResultPrinter');
    }
}
