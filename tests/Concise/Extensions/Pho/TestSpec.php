<?php

// Here we will test the integrations of Pho with concise. Since the whole Pho
// test suite is run as part of the concise build process we will not test Pho
// native things unless concise plays a roll in how they are carried out.
describe(
    'Pho integration with concise',
    function () {
        // You may use all the native Pho expectations or the concise assertions
        // from the same $this context.
        context(
            'Pho expectations and concise assertions',
            function () {
                // This is not strictly necessary but it makes sense to have at
                // least one of these.
                it(
                    'should be able to use native Pho expectations',
                    function () {
                        expect(true)->toBe(true);
                    }
                );

                // Make sure the Pho failed expectations get handled as PHPUnit
                // failures.
                it(
                    'will export expectation as PHPUnit failures',
                    function () {
                        expect(true)->toBe(false);
                    }
                );
            }
        );

        it(
            'should be able to use concise assertions',
            function () {
                $this->assert(true)->isTrue;
            }
        );

        it(
            'will add concise assertion failures',
            function () {
                $this->assert(true)->isFalse;
            }
        );

        it('will allow incomplete specs');

        it(
            'should masquerade $this as as a Pho suite',
            function () {
                $this->assert($this)->isAnInstanceOf('pho\Suite\Suite');
            }
        );
    }
);
