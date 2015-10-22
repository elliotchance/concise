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

``private`` properties are attached to a specific class. Therefore a parent and
child class can contain ``private`` instance variables by the same name that are
completely independent.

.. code-block:: php

   class A
   {
       private $value = 'foo';
   }

   class B extends A
   {
       private $value = 'bar';
   }

.. code-block:: php

   public function testPrivates()
   {
       $object = new B();
       $parent = get_parent_class($object);

       $this->getProperty($object, 'value');                 // 'bar'
       $this->getProperty($object, 'value', $parent);        // 'foo'

       $this->setProperty($object, 'value', 'baz');          // B::$value is set.
       $this->setProperty($object, 'value', 'baz', $parent); // A::$value is set.
   }

Concise will automatically determine which class in the hierarchy contains the
property to be set if no explicit class name is provided. If multiple classes
contain the same property the most child class is used.

When an explicit class is provided that class is always used whether the
property exists on that class or not.
