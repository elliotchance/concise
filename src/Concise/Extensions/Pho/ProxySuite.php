<?php

namespace Concise\Extensions\Pho;

use pho\Suite\Suite;

/**
 * To make the assertions from concise available natively through Pho specs we
 * need to intercept magic calls.
 */
class ProxySuite extends Suite
{
    public function __call($key, $args = [])
    {
        return ConciseReporter::$testCase->__call($key, $args);
    }
}
