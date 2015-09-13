Extending Concise
=================

Using Concise with Other Frameworks
-----------------------------------

Concise is designed to work perfectly over the top of PHPUnit. But it can also
be used by any other framework by simply instantiating and managing the
``Concise\Core\TestCase`` yourself:

.. code-block:: php

   use \Concise\Core\TestCase;

   class MyTinyTestSuite
   {
       protected $testCase;

       public function __construct()
       {
           $this->testCase = new TestCase();
       }

       public function checkSomething()
       {
           $this->testCase->setUp();
           $this->testCase->assert(3 + 5, equals, 8);
           $this->testCase->tearDown();
       }
   }

Since Concise implicitly expects ``setUp()`` and ``tearDown()`` methods to be
called at appropriate times but does not enforce this behaviour - if you use it
differently then it may do unexpected things.
