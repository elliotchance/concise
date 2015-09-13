Actions
-------

andDo(callback)
~~~~~~~~~~~~~~~

.. code-block:: php

   $this->mock()
        ->stub('myMethod')->andDo(function() {
            echo "myMethod() was called.";
        }))
        ->get();

This can also be used as a way to handle state that might be too complicated for
the mocking engine:

.. code-block:: php

   $calledOddTimes = false;
   $this->mock()
        ->stub('myMethod')->andDo(function() use (&$calledOddTimes) {
            $calledOddTimes = !$calledOddTimes;
        }))
        ->get();
   $this->assert($calledOddTimes)->isTrue;

``andDo`` will pass through arguments:

.. code-block:: php

   $mock = $this->mock('MyClass')
                ->expect('foo')->andDo(function ($a, $b) {
                    echo $a + $b;
                })
                ->get();

   $mock->foo(3, 5);

   // prints:
   // 8

andReturn(value)
~~~~~~~~~~~~~~~~

Return ``value`` where ``value`` can be of any type.

You may also provide more than one argument to specify multiple resturn values:

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturn('foo', 123)
                ->get();
   $mock->myMethod(); // 'foo'
   $mock->myMethod(); // 123

When using multiple return values the method can not be called more times than
you have return values for - otherwise an exception is thrown.

andReturnCallback(callback)
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Return the value returned by a callback function.

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturnCallback(function () {
                   return 'foo';
                })
                ->get();
   $mock->myMethod(); // 'foo'

The return value is evaluated when the invocation is made, so you can return
different values for each invocation.

An optional ``Concise\Mock\InvocationInterface`` is passed through as the first
and only argument to gain insight about the invocation:

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturnCallback(
                    function (InvocationInterface $invoke) {
                        return $invoke->getInvokeCount();
                    }
                )
                ->get();
   $mock->myMethod(); // 1
   $mock->myMethod(); // 2

You can also access the invocation arguments:

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturnCallback(
                    function (InvocationInterface $invoke) {
                        return $invoke->getArgument(1);
                    }
                )
                ->get();
   $mock->myMethod('foo', 'bar'); // bar

andReturnProperty(propertyName)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To return the value of a property (of any visibility) when a method is invoked
you can use ``andReturnProperty()``:

.. code-block:: php

   class MyClass
   {
       protected $hidden = 'foo';

       public function myMethod()
       {
           return 'bar';
       }
   }

   $mock = $this->mock()
                ->stub('myMethod')->andReturnProperty('hidden')
                ->get();
   $mock->myMethod(); // foo

andReturnSelf()
~~~~~~~~~~~~~~~

Return the mock instance (``return $this``). This is useful when you are mocking
classes that using the chaining principle with methods.

andThrowException(exception)
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Throw the ``exception`` when the method is called.

.. code-block:: php

   $this->mock()
        ->stub('myMethod')->andThrow(new \Exception('Uh-oh!'))
        ->get();
