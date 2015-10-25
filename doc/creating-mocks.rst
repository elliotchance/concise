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

This type of mock does not invoke the constructor since plain mocks are supposed
to be totally hollow and the constructor could potentially setup an unexpected
state or call methods that would not have actions associated with them.


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


Cloning
~~~~~~~

If you need to disable the ``__clone()`` of the original class you can:

.. code-block:: php

   $this->niceMock('\My\Class')
        ->disableClone()
        ->...

This will stub off the ``__clone()`` so that it does nothing.


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
