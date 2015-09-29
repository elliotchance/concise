<?php

namespace Concise\Spec;

class SpecTestCaseTest extends SpecTestCase
{
    public function spec()
    {
        $this->describe(
            'Calculator',
            function () {
                $this->it(
                    'should add up some numbers',
                    function () {
                        $this->assert(3 + 5)->equals(8);
                    }
                );

                $this->it(
                    'should subtract some numbers',
                    function () {
                        $this->assert(3 - 5)->equals(-2);
                    }
                );
            }
        );
    }
}
