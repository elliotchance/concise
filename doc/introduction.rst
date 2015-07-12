Introduction
============

Simple Example
--------------

.. code-block:: php

   class MyTest extends TestCase
   {
       public function testAssertionsCanBeBuiltWithChaining()
       {
           $result = 100 + 23;
           $this->assert($result, exactly_equals, 123);

           $a = ['foo' => 'bar'];
           $this->assert($a, is_an_associative_array);
           $this->assert($a, has_key, 'foo', with_value, 'bar');
       }

       public function testAssertionsAreJustStrings()
       {
           $this->assert('123 equals "123"');
       }

       public function testAttributesAreNativelyUnderstood()
       {
           $this->foo = 'bar';
           $this->assert('foo is the same as "bar"');
       }

       public function testVerify()
       {
           $a = ['foo' => 'bar'];
           $this->verify($a, has_key, 'foo', with_value, 'bar');
           $this->verify($a, has_key, 'bar', with_value, 'baz');
           // This test will always finish, all the failed verifications
           // will be displayed at the end.
       }

       public function testNestedAssertion()
       {
           $a = ['foo' => 1.23];
           $this->assert($this->assert($a, has_key, 'foo'), equals, 1.2, within, 0.1);
       }
   }
