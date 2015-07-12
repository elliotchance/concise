Extending Concise
=================

Create the Matcher Class
------------------------

.. code-block:: php

   class MyMatcher extends \Concise\Matcher\AbstractMatcher
   {
       /**
        * @return array All of the syntaxes this matcher will respond to.
        */
       public function supportedSyntaxes()
       {
           return array(
               '? equals ?',
               '? is equal to ?'
           );
       }

       /**
        * Perform the match.
        * @param string $syntax The syntax that we are evaluating (like '? equals ?').
        * @param array $data Placeholders are matched to indicies of $data.
        * @return TRUE on success, FALSE for failure.
        */
       public function match($syntax, array $data = array())
       {
           return ($data[0] == $data[1]);
       }
   }

Somewhere in your test (or your bootstrap) you can get the default parser and
register your class:

.. code-block:: php

   $defaultParser = \Concise\Syntax\MatcherParser::getInstance();
   $defaultParser->registerMatcher(new MyMatcher());

Limiting Matchers to Data Types
-------------------------------

You can alter the syntax of your matchers to only allow certain data types to be
passed into arguments:

.. code-block:: none

   '?:array has at least ?:int items'

Your matcher can be guarenteed of these types so you need not do any further
error checking. It may also serve as documentation to the person writing tests.

If a value is passed that is different from what is listed then the test will
fail with an appropriate message like:

.. code-block:: none

   Argument 1 (abc) must be int.

You may also specify multiple accepted types like:

.. code-block:: none

   '?:array,object has at least ?:int properties'

Or even use a black list (any type except objects or arrays are allowed):

.. code-block:: none

   '?:!object,array has length of ?:int'

Testing Your Matcher
--------------------

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
