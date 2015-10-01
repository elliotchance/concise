<?php

use Concise\Core\TestCase;

$t = new TestCase();

describe(
    'Calculator',
    function () use ($t) {
        it(
            'should add up some numbers',
            function () use ($t) {
                $t->assert(3 + 5)->equals(8);
            }
        );

        it(
            'fails',
            function () use ($t) {
                $t->assert(3 - 5)->equals(0);
            }
        );

        it(
            'should subtract some numbers',
            function () use ($t) {
                $t->assert(3 - 5)->equals(-2);
            }
        );

        it(
            'should subtract some numbers',
            function () use ($t) {
                $t->assert(3 - 5)->equals(-2);
            }
        );
    }
);
