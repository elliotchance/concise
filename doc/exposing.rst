Exposing
--------

Methods
~~~~~~~

Exposing a method will simply make its visibility ``public`` this does not
interfere with any actions behavior of the method:

.. code-block:: php

   class MyClass
   {
       protected function foo()
       {
           return 'bar';
       }
   }

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->expose('foo')
                ->get();
   $mock->foo();

If you need to expose several methods there is also a variety of ways this can
be done:

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->expose('foo')
                ->expose('bar')
                ->get();

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->expose(['foo', 'bar'])
                ->get();

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->expose('foo', 'bar')
                ->get();

Some caveats:

 * The method you are exposing must exist, but it doesn't have to be
   ``protected``. Exposing a ``public`` method is allowed but would have no
   effect.

 * You cannot expose a ``private`` method. If you try you will get an exception.

All Methods
~~~~~~~~~~~

In some cases you may want to expose all the non-public methods in a mock. This
is generally unwise because your testing code should ideally only use the public
API provided by the objects and services that you are testing.

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->exposeAll()
                ->get();

   $mock->secretMethod();

``exposeAll()`` will actually retrieve the methods available on the object and
promote any method that is not ``final`` or ``private`` to a ``public``
visibility. See `Mocking Final Classes and Methods`_ for more information.

.. _Mocking Final Classes and Methods: mocking-limitations.html#final-classes-and-methods

Properties
~~~~~~~~~~

In some case you may also want to get or set properties on an object that do not
have a public visibility.

.. code-block:: php

   class MyClass
   {
       protected $value = 'foo';
   }

.. code-block:: php

   public function testValueIsFoo()
   {
       $myClass = new MyClass();
       $this->assert($this->getProperty($myClass, 'value'))->equals('foo');
   }

The above will work for all visibilities of a property.

Likewise you can use the ``setProperty`` method provided by
``Concise\Core\TestCase``:

.. code-block:: php

   public function testValueIsBar()
   {
       $myClass = new MyClass();
       $this->setProperty($myClass, 'value', 'bar');
       $this->assert($this->getProperty($myClass, 'value'))->equals('bar');
   }
