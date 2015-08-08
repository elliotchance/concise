<?php

namespace Concise\Modules\Files;

use Concise\Matcher\AbstractMatcherTestCase;

abstract class AbstractFileTestCase extends AbstractMatcherTestCase
{
    protected function createTempFile()
    {
        $fileName = tempnam('', 'concise');
        file_put_contents($fileName, 'baz');
        return $fileName;
    }
}
