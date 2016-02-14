<?php

namespace Concise\Core;

/**
 * Used to get around limitations with PHPUnit reporting the correct number of
 * tests in a case or suite. The default functionality for PHPUnit is that test
 * suites and cases is to count and aggregate the number of methods that are
 * prefixed with "test" - this is no good if we need custom logic to determina
 * how many tests there are in the suite.
 *
 * Instances that override this will be handled differently internally when
 * preparation begins. The normal count() method will be ignored in favor of the
 * getRealCount() method provided.
 */
interface VirtualTestSuiteInterface
{
    /**
     * @return int
     */
    public function getRealCount();
}
