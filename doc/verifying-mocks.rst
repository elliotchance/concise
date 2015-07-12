Verifying Mocks
---------------

All mocks are automatically asserted (checking that all the requirements have
been fulfilled) at the end of each test case.

Manually Verifying Mocks
~~~~~~~~~~~~~~~~~~~~~~~~

Sometimes you may want or need to verify them before the end of the test. For
example:

.. code-block:: php

   public function testMock()
   {
       $mock = $this->mock('MyClass')
                    ->expect('myMethod')
                    ->get();
       // ... do some stuff
       $this->assertMock($mock);
   }

In the example above the mock will be asserted on the spot and cause the same
failure if any requirements are no fulfilled, however it does some other things
to the mock:

* A mock can only be asserted once, that means that since we are validating it
  here it will *not* be validated again when the test ends, and;
* Validating a mock more than once (calling ``assertMock()``) more than once on
  the same mock will yield an error.
