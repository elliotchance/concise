Stubbing
--------

*Stubbing* is the act of changing the return value or associated action of a
method when it is invoked (the basic principle of a mock). You are not specifing
any expectation so the stubbed method may be called zero or more times:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub('add')->andReturn(8)
                          ->get();

   $calculatorMock->add(); // returns 8

If you only want to stub a method to return a value then you can use the array
version to specify one or more stubs:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub(['add' => 8])
                          ->get();

Concise allows for all the same rules with ``static`` methods with exactly the
same syntax.

Setting the Same Actions on Multiple Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You can set actions on multiple methods at the same time by specifying them in
the same clause like:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub('add', 'subtract')->andReturn(0)
                          ->get();

In the above example both ``add`` and ``subtract`` will return ``0`` when
called. It is a shorter way of writing:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub('add')->andReturn(0)
                          ->stub('subtract')->andReturn(0)
                          ->get();

   // or

   $calculatorMock = $this->mock('\Calculator')
                          ->stub(['add' => 0, 'subtract' => 0])
                          ->get();
