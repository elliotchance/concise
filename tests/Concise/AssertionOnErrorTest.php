<?php

namespace Concise;

use \Concise\Syntax\Code;
use \Concise\Syntax\MatcherParser;
use \Concise\Matcher\True;
use \Concise\Matcher\False;

class AssertionOnErrorTest extends TestCase
{
    public function testOnErrorMustBeDefined()
    {
        $this->assert(defined('on_error'));
    }
}
