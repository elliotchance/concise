<?php

namespace Concise\Console\ResultPrinter;

use Concise\TestCase;

class CIResultPrinterTest extends TestCase
{
    public function testUpdateCallsWrite()
    {
        $resultPrinter = $this->niceMock('Concise\Console\ResultPrinter\CIResultPrinter')
                              ->expect('write')
                              ->get();
        $resultPrinter->update();
    }
}
