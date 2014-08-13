<?php

namespace Concise\Matcher;

abstract class AbstractFileTestCase extends AbstractMatcherTestCase
{
    protected function createTempFile()
    {
        $fileName = tempnam('', 'concise');
        file_put_contents($fileName, 'baz');
        return $fileName;
    }
}
