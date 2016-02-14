Expectations
------------

Expectations require some criteria to be fulfilled during the test. This may be
that a method is called a specified amount of times:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expect('add')->once()->andReturn(8)
                          ->get();

The number of exptected times may be one of:

 * ``never()`` - fail if this method is called.
 * ``once()`` - must be exactly once.
 * ``twice()`` - must be called exactly twice.
 * ``times(int)`` - exact number of times.

All method expectations must have an action except in the case of ``never()``.

Stubs and expectation share the same commonality when it comes to actions when
the method is called.

For convenience there is also an ``expects`` method that performs exactly the
same way.

Setting the Same Expectations on Multiple Methods
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Like stubbing, you can set requirements on multiple methods at the same time by
specifying them in the same clause like:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add', 'subtract')
                          ->get();

In the above example both ``add`` and ``subtract`` will be expected to be
called, it is a shorter way of writing:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add')
                          ->expects('subtract')
                          ->get();

Likewise, an action or requirement will be applied to all of the methods in the
clause like:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add', 'subtract')->twice()->andReturn(0)
                          ->get();

``add`` and ``subtract`` will be each have to be called twice and will return
``0``.

Expecting Arguments
~~~~~~~~~~~~~~~~~~~

Stubs and expectations may have an additional ``with()`` clause:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub('add')->with(3, 5)->andReturn(8)
                          ->get();

   $calculatorMock->add(3, 5); // returns 8

You may specify more than one ``with()`` condition to handle different
scenarios:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->stub('add')->with(3, 5)->andReturn(8)
                                       ->with(2, 7)->andReturn(9)
                          ->get();

When you are using ``with()`` you cannot specify the number of expected calls
for a method, but rather you must specify the number of times for each
``with()`` condition:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add')->with(3, 5)->twice()
                                          ->with(2, 7)
                          ->get();

In the example above ``add(3, 5)`` must be invoked twice *and* ``add(2, 7)``
must be invoked once (the ``expects`` clause will default to once).

Ignoring Parameter Values
~~~~~~~~~~~~~~~~~~~~~~~~~

Sometimes you only need to restrict some of the incoming paramter values, in
this case there is a ``ANYTHING`` constant provided by
``Concise\Core\TestCase``:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add')->with(3, self::ANYTHING)
                          ->get();
