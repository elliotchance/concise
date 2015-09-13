Modules
=======

Modules contain matchers for assertions. If you need to create your own
assertions you will likely want to create one or more modules.


Creating a Module
-----------------

Each module consists of a single `YAML`_ file describing the module and the
syntaxes it supports. This file can be placed anywhere can be named anything you
like. A simple example looks like:

.. _YAML: https://en.wikipedia.org/wiki/YAML

.. code-block:: yaml

   module:
     name: My Module
     description: Just some custom stuff I need.

     syntaxes:
       "?:string starts with ?:string":
         method: Concise\Modules\Strings\StringStartsWith::match
         description: Assert a string starts (begins) with another string.

       "?:string ends with ?:string":
         method: Concise\Modules\Strings\StringEndsWith::match
         description: Assert a string ends with another string.

It is recommended that you put all of your classe and YAML configuration in the
same directory. An good example of a complete module can be found in the
`concise source code`_:

.. _concise source code: https://github.com/elliotchance/concise/master/src/Concise/Modules/RegularExpressions


Creating a Matcher
------------------

The only real requirement for a matcher is that it extends
``Concise\Matcher\AbstractModule``:

.. code-block:: php

   use Concise\Matcher\AbstractModule

   class MyMatcher extends AbstractModule
   {
       public function match($syntax, array $data = array())
       {
           return ($data[0] == $data[1]);
       }
   }

The YAML configuration (above) specifies which syntaxes should goto which
matcher classes. You may have multiple syntaxes pointed to the same ``method``
or different syntaxes pointed to the same class. How you configure your module
is upto you.

 * ``$syntax`` is the original syntax, for example
   ``?:string starts with ?:string``.

 * ``$data`` contains the ordered data items from the syntax. If the assertion
   was ``"foo" starts with "food"`` then ``$data`` would be
   ``array("foo", "food")``.


Testing the Matcher
~~~~~~~~~~~~~~~~~~~

Use the ``Concise\Matcher\AbstractMatcherTestCase`` when testing matchers:

.. code-block:: php

   class IsAnIntegerTest extends AbstractMatcherTestCase
   {
       public function setUp()
       {
           parent::setUp();
           $this->matcher = new IsAnInteger();
       }

       public function testIntegerIsAnInteger()
       {
           $this->assert('123 is an integer');
       }

       public function testFloatIsNotAnInteger()
       {
           $this->assertFailure('123.0 is an integer');
       }
   }

``assertFailure()`` is only provided though
``Concise\Matcher\AbstractMatcherTestCase`` and is not available through
general test cases.



Loading Modules
---------------

Loading a module is as easy as loading the YAML configuration file into the
main instance of the ``ModuleManager``:

.. code-block:: php

   use Concise\TestCase
   use Concise\Syntax\ModuleManager;

   class MyTest extends TestCase
   {
       public static function setUpBeforeClass()
       {
           ModuleManager::getInstance()->loadModule('mymodule.yml');
       }
   }

Some things to note:

 * It is safe to load the same module multiple times. Internally modules are
   identified by their configuration file so loading the same configuration
   file will be ignored.

 * Once modules are loaded into the ``ModuleManager`` they remain there for the
   entire run. If you had a bootstrap file for your test suite it would be a
   good idea to load your modules here, otherwise putting them in the
   appropriate test cases is fine too.
