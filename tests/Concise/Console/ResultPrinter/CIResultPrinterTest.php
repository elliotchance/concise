<?php

namespace Concise\Console\ResultPrinter;

use Concise\Console\Theme\DefaultTheme;
use Concise\Core\TestCase;

class CIResultPrinterTest extends TestCase
{
    public function testUpdateCallsWrite()
    {
        $resultPrinter =
            $this->niceMock(
                'Concise\Console\ResultPrinter\CIResultPrinter',
                [new DefaultTheme()]
            )
                ->expect('write')
                ->get();
        $resultPrinter->update();
    }

    public function testAppendTextAbovePrintsANewLineAbove()
    {
        $resultPrinter =
            $this->niceMock(
                'Concise\Console\ResultPrinter\CIResultPrinter',
                [new DefaultTheme()]
            )
                ->expect('write')
                ->stub('update')
                ->stub('restoreCursor')
                ->get();
        $resultPrinter->appendTextAbove('a');
    }
}
