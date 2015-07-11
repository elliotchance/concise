Mocking
=======

Creating Mocks
--------------

There are three types of mocks available:

 * `Normal mocks`_ (or simply *mocks*) define the behavior for every method you
   expect to interact with. If you test interacts with any method other than
   what you have explicitly stated an exception will be thrown.

 * `Nice mocks`_ work like the original object where if you don't specify a
   given action for a method it will perform as if the mock didn't exist (pass
   through to the original method).

 * `Partial mocks`_ create a mock from an already existing object. This means
   you can add custom rules to an object that already contains some arbitrary
   state.

Normal Mocks
~~~~~~~~~~~~

.. code-block:: php

   $this->mock('\My\Class')
        ->expect('myMethod')->once()->andReturn(123)
        ->stub('myOtherMethod')->andThrow(new \Exception('Uh-oh!'));
        ->get();

The class you are mocking must exist. Either already loaded or able to be loaded
through the class loader(s). This is not a limitation because concise does this
for safety. If you want to create a mock but you do not need to inherit from
another class then you can leave the class name out and a mock will be created
from a ``\stdClass``:

.. code-block:: php

   $this->mock()
        ->expect('myMethod')->andReturn(123)
        ->get();

Nice Mocks
~~~~~~~~~~

Nice mocks work like the original object where if you don't specify a given
action for a method it will perform as if the mock didn't exist (pass through to
the original method).

.. code-block:: php

   $this->niceMock('\My\Class')
        ->...
        ->get();

Partial Mocks
~~~~~~~~~~~~~

Partial mocks create a mock from an already existing object. This means you can
add custom rules to an object that already contains some arbitrary state.

.. code-block:: php

   $calculator = new Calculator();
   $calculator->setMemory(10);

   $mock = $this->partialMock($calculator)
                ->get();

   $mock->addToMemory(20);
   $mock->getMemory(); // 30

Constructors
~~~~~~~~~~~~

If you are mocking a class with a constructor you can provide the constructor
arguments as a second parameter:

.. code-block:: php

   class MyClass
   {
       public function __construct($number, $string) {}
   }

   $this->mock('\My\Class', array(123, 'foobar'))
        ->...

Or you can disable the original constructor:

.. code-block:: php

   $this->mock('\My\Class')
        ->disableConstructor()
        ->...

**Note:** Constructors are always run by default, even in normal mocks (which
have all methods stubbed off). The reason for this is even in a normal mock you
may want the constructor to set up the state of the object, whilst leaving you
with the ability to turn this off with ``disableConstructor()``.

Programmatically Building Mocks
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

You would have noticed that all mock definitions end with ``get()`` which
compiles the rules into the actual mock for use. If you try to use the object
before then you will be talking to the ``MockBuilder`` instance.

This allows you to generate mocks programmatically:

.. code-block:: php

   public function createMockForCalc($expectsAdd = false)
   {
       $mock = $this->mock('\My\Calculator');
       if ($expectsAdd) {
           $mock->expects('add');
       }
       else {
           $mock->stub('add');
       }
       $mock->andReturn(8);
       return $mock->get();
   }

Conversely, you may use ``get()`` multiple times to generate different classes
with the same rules:

.. code-block:: php

   $mockTemplate = $this->mock()
                        ->stub(['add' => 8]);
   $mock1 = $mockTemplate->get();
   $mock2 = $mockTemplate->get();

   echo get_class($mock1) . " " . get_class($mock2); // stdClass_abd1240f stdClass_4432eba7

Changing the Class Name and Namespace of a Mock
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The name of your class will be generated automatically to be unique, however if
you want to name your class something specific you can specify this:

.. code-block:: php

   $mock = $this->mock('\My\Calculator')
                ->setCustomClassName('Calc')
                ->get();
   echo get_class($mock);

   // My\Calc

If the class name you specify does not contain a namespace then it will be
placed into the same namespace as the original class you are mocking. However,
you can change the namespace completely by specifying the fully-qualified class:

.. code-block:: php

   $mock = $this->mock('\My\Calculator')
                ->setCustomClassName('Secret\Location\Calc')
                ->get();
   echo get_class($mock);

   // Secret\Location\Calc

Or even move the class into the global namespace by preceding the class name
with a backslash:

.. code-block:: php

   $mock = $this->mock('\My\Calculator')
                ->setCustomClassName('\Calculator')
                ->get();
   echo get_class($mock);

   // Calculator

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
       $this->assert($this->getProperty($myClass, 'value'), equals, 'foo');
   }

The above will work for all visibilities of a property.

Likewise you can use the ``setProperty`` method provided by
``Concise\TestCase``:

.. code-block:: php

   public function testValueIsBar()
   {
       $myClass = new MyClass();
       $this->setProperty($myClass, 'value', 'bar');
       $this->assert($this->getProperty($myClass, 'value'), equals, 'bar');
   }

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
this case there is a ``ANYTHING`` constant provided by ``Concise\TestCase``:

.. code-block:: php

   $calculatorMock = $this->mock('\Calculator')
                          ->expects('add')->with(3, self::ANYTHING)
                          ->get();

Manually Verifying Mocks
------------------------

All mocks are automatically asserted (checking that all the requirements have
been fulfilled) at the end of each test case. However, sometimes you may want or
need to verify them before the end of the test. For example:

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

Actions
-------

andDo(callback)
~~~~~~~~~~~~~~~

.. code-block:: php

   $this->mock()
        ->stub('myMethod')->andDo(function() {
            echo "myMethod() was called.";
        }))
        ->done();

This can also be used as a way to handle state that might be too complicated for
the mocking engine:

.. code-block:: php

   $calledOddTimes = false;
   $this->mock()
        ->stub('myMethod')->andDo(function() use (&$calledOddTimes) {
            $calledOddTimes = !$calledOddTimes;
        }))
        ->get();
   $this->assert($calledOddTimes);

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
                ->done();
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
                ->done();
   $mock->myMethod(); // 'foo'

The return value is evaluated when the invocation is made, so you can return
different values for each invocation.

An optional ``Concise\Mock\InvocationInterface`` is passed through as the first
and only argument to gain insight about the invocation:

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturnCallback(function (InvocationInterface $invoke) {
                   return $invoke->getInvokeCount();
                })
                ->done();
   $mock->myMethod(); // 1
   $mock->myMethod(); // 2

You can also access the invocation arguments:

.. code-block:: php

   $mock = $this->mock()
                ->stub('myMethod')->andReturnCallback(function (InvocationInterface $invoke) {
                   return $invoke->getArgument(1);
                })
                ->done();
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
                ->done();
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
        ->done();

Limitations
-----------

Traits
~~~~~~

A ``trait`` cannot be mocked: `Issue #66`_

.. _Issue #66: https://github.com/elliotchance/concise/issues/66

Final Classes and Methods
~~~~~~~~~~~~~~~~~~~~~~~~~

Classes that are ``final`` will not be available to mock - an exception will be
thrown if this is attempted.

This also applies to ``final`` methods.

Setting Properties
------------------

Setting a Single Property
~~~~~~~~~~~~~~~~~~~~~~~~~

You can set a properties when creating a mock using ``setProperty``:

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->setProperty('foo', 'bar')
                ->get();

   $this->foo; // bar

Setting Multiple Properties
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Setting multiple properties can be done with ``setProperties``:

.. code-block:: php

   $mock = $this->niceMock('MyClass')
                ->setProperties([
                    'foo' => 'bar',
                    'bar' => 'baz',
                ])
                ->get();

   $this->bar; // baz

When using ``setProperties`` it will *add on* the provided properties, not
replace any previously set ones.

Other Information
~~~~~~~~~~~~~~~~~

**Note:** The property or properties are set after all other aspects of the mock
have been setup. This means properties that may be set as part of a
`partial mock`_ will be overridden by the properties provided.

This feature was introduced in `Multiverse (Release v1.7)`_.
