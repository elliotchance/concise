<?php

namespace Concise\Services;

use Concise\TestCase;

class ArgumentCheckerTest extends TestCase
{
    public function testSuccessReturnsTrue()
    {
        $this->assert(ArgumentChecker::check(123, 'int'), is_true);
    }
}
