Matchers (Assertions)
=====================

.. start matchers

Arrays
------

* `array`_ contains `mixed`_ -  Assert an array has at least one occurrence of the given value.   
* `array`_ does not contain `mixed`_ -  Assert an array does not have any occurrences of the given value.   
* `array`_ does not have item `array`_ -  Assert an array does not have key and value item.   
* `array`_ does not have key `int`_\|\ `string`_ -  Assert an array does not have a key.   
* `array`_ does not have keys `array`_ -   
* `array`_ does not have value `mixed`_ -  Assert an array does not have any occurrences of the given value.   
* `array`_ has item `array`_ -  Assert an array has key and value item.   
* `array`_ has items `array`_ -  Assert an array has all key and value items.   
* `array`_ has key `int`_\|\ `string`_ -  Assert an array has key, returns value.   
* `array`_ has keys `array`_ -  Assert an array has several keys in any order.   
* `array`_ has value `mixed`_ -  Assert an array has at least one occurrence of the given value.   
* `array`_ has values `array`_ -  Assert an array has several values in any order.   
* `array`_ is an associative array -  Assert an array is associative.   
* `array`_ is an empty array -  Assert an array is empty (no elements).   
* `array`_ is empty array -  Assert an array is empty (no elements).   
* `array`_ is not an associative array -  Assert an array is not associative.   
* `array`_ is not an empty array -  Assert an array is not empty (at least one element).   
* `array`_ is not empty array -  Assert an array is not empty (at least one element).   
* `array`_ is not unique -  Assert that an array only has at least one element that is repeated.   
* `array`_ is unique -  Assert that an array only contains unique values.   

Basic
-----

* `mixed`_ does not equal `mixed`_ -  Assert two value do not match with no regard to type.   
* `mixed`_ does not exactly equal `mixed`_ -  Assert two values are of exactly the same type and value.   
* `mixed`_ equals `mixed`_ -  Assert values with no regard to exact data types.   
* `mixed`_ exactly equals `mixed`_ -  Assert two values match data type and value.   
* `mixed`_ is equal to `mixed`_ -  Assert values with no regard to exact data types.   
* `mixed`_ is exactly equal to `mixed`_ -  Assert two values match data type and value.   
* `mixed`_ is not equal to `mixed`_ -  Assert two value do not match with no regard to type.   
* `mixed`_ is not exactly equal to `mixed`_ -  Assert two values are of exactly the same type and value.   
* `mixed`_ is not the same as `mixed`_ -  Assert two values are of exactly the same type and value.   
* `mixed`_ is the same as `mixed`_ -  Assert two values match data type and value.   
* `mixed`_ not equals `mixed`_ -  Assert two value do not match with no regard to type.   

Booleans
--------

* `mixed`_ is false -  Assert value is false.   
* `mixed`_ is falsy -  Assert a value is a false-like value.   
* `mixed`_ is true -  Assert a value is true.   
* `mixed`_ is truthy -  Assert a value is a non false-like value.   
* false -  Always fail.   
* true -  Always pass.   

Date and Time
-------------

* date `int`_\|\ `string`_\|\ `DateTime`_ is after `int`_\|\ `string`_\|\ `DateTime`_ -  A date/time is after another date/time, returns original date in the same format as provided.   
* date `int`_\|\ `string`_\|\ `DateTime`_ is before `int`_\|\ `string`_\|\ `DateTime`_ -  A date/time is before another date/time, returns original date in the same format as provided.   

Exceptions
----------

* `callable`_ does not throw `class`_ -  Assert that a specific exception is not thrown.   
* `callable`_ does not throw exception -  Assert that no exception is thrown.   
* `callable`_ throws `class`_ -  Assert a specific exception was thrown.   
* `callable`_ throws anything except `class`_ -  Assert any exception except a specific one was thrown.   
* `callable`_ throws exactly `class`_ -  Assert a specific exception was thrown.   
* `callable`_ throws exception -  Assert an exception was thrown.   

Files
-----

* `string`_ does not equal file `string`_ -  Compare string value with the contents of a file.   
* `string`_ equals file `string`_ -  Compare string value with the contents of a file.   

Numbers
-------

* `number`_ between `number`_ and `number`_ -  A number must be between two values (inclusive), returns value.   
* `number`_ greater than `number`_ -  A number is greater than another number.   
* `number`_ greater than or equal `number`_ -  A number is greater than or equal to another number.   
* `number`_ gt `number`_ -  A number is greater than another number.   
* `number`_ gte `number`_ -  A number is greater than or equal to another number.   
* `number`_ is between `number`_ and `number`_ -  A number must be between two values (inclusive), returns value.   
* `number`_ is greater than `number`_ -  A number is greater than another number.   
* `number`_ is greater than or equal to `number`_ -  A number is greater than or equal to another number.   
* `number`_ is less than `number`_ -  A number is less than another number.   
* `number`_ is less than or equal to `number`_ -  A number is less than or equal to another number.   
* `number`_ is not between `number`_ and `number`_ -  A number must not be between two values (inclusive).   
* `number`_ is not within `number`_ of `number`_ -  Assert two values are not close to each other.   
* `number`_ is within `number`_ of `number`_ -  Assert two values are close to each other.   
* `number`_ less than `number`_ -  A number is less than another number.   
* `number`_ less than or equal `number`_ -  A number is less than or equal to another number.   
* `number`_ lt `number`_ -  A number is less than another number.   
* `number`_ not between `number`_ and `number`_ -  A number must not be between two values (inclusive).   

Objects and Classes
-------------------

* `object`_ does not have property `string`_ -  Assert that an object does not have a property.   
* `object`_ has property `string`_ -  Assert that an object has a property. Returns the properties value.   

Regular Expressions
-------------------

* `string`_ does not match regex `regex`_ -   
* `string`_ does not match regular expression `regex`_ -   
* `string`_ doesnt match regex `regex`_ -   
* `string`_ doesnt match regular expression `regex`_ -   
* `string`_ matches regex `regex`_ -   
* `string`_ matches regular expression `regex`_ -   

Strings
-------

* `mixed`_ does not end with `mixed`_ -  Assert a string does not end with another string.   
* `mixed`_ does not start with `mixed`_ -  Assert a string does not not start (begin) with another string.   
* `string`_ contains case insensitive string `string`_ -  A string contains a substring (ignoring case-sensitivity). Returns original string.   
* `string`_ contains string `string`_ -  A string contains a substring. Returns original string.   
* `string`_ does not contain case insensitive string `string`_ -  A string does not contain a substring (ignoring case-sensitivity). Returns original string.   
* `string`_ does not contain string `string`_ -  A string does not contain a substring. Returns original string.   
* `string`_ ends with `string`_ -  Assert a string ends with another string.   
* `string`_ is blank -  Assert a string is zero length.   
* `string`_ is not blank -  Assert a string has at least one character.   
* `string`_ starts with `string`_ -  Assert a string starts (begins) with another string.   

Types
-----

* `mixed`_ is a bool -  Assert a value is true or false.   
* `mixed`_ is a boolean -  Assert a value is true or false.   
* `mixed`_ is a number -  Assert that a value is an integer or floating-point.   
* `mixed`_ is a string -  Assert value is a string.   
* `mixed`_ is an array -  Assert a value is an array.   
* `mixed`_ is an int -  Assert value is an integer type.   
* `mixed`_ is an integer -  Assert value is an integer type.   
* `mixed`_ is an object -  Assert value is an object.   
* `mixed`_ is not a bool -  Assert a value is not true or false.   
* `mixed`_ is not a boolean -  Assert a value is not true or false.   
* `mixed`_ is not a number -  Assert that a value is not an integer or floating-point.   
* `mixed`_ is not a string -  Assert a value is not a string.   
* `mixed`_ is not an array -  Assert a value is not an array.   
* `mixed`_ is not an int -  Assert a value is not an integer type.   
* `mixed`_ is not an integer -  Assert a value is not an integer type.   
* `mixed`_ is not an object -  Assert a value is not an object.   
* `mixed`_ is not null -  Assert a value is not null.   
* `mixed`_ is not numeric -  Assert value is not a number or string that represents a number.   
* `mixed`_ is null -  Assert a value is null.   
* `mixed`_ is numeric -  Assert value is a number or string that represents a number.   
* `object`_\|\ `class`_ instance of `class`_ -  Assert an objects class or subclass.   
* `object`_\|\ `class`_ is an instance of `class`_ -  Assert an objects class or subclass.   
* `object`_\|\ `class`_ is instance of `class`_ -  Assert an objects class or subclass.   
* `object`_\|\ `class`_ is not an instance of `class`_ -  Assert than an object is not a class or subclass.   
* `object`_\|\ `class`_ is not instance of `class`_ -  Assert than an object is not a class or subclass.   
* `object`_\|\ `class`_ not instance of `class`_ -  Assert than an object is not a class or subclass.   

URLs
----

* url `string`_ has fragment `string`_ -  URL has fragment.   
* url `string`_ has host `string`_ -  URL has host.   
* url `string`_ has password `string`_ -  URL has password.   
* url `string`_ has path `string`_ -  URL has path.   
* url `string`_ has port `integer`_ -  URL has port.   
* url `string`_ has query `string`_ -  URL has query.   
* url `string`_ has scheme `string`_ -  URL has scheme.   
* url `string`_ has user `string`_ -  URL has user.   
* url `string`_ is valid -  Validate URL.   


.. end matchers

.. _array: #
.. _callable: #
.. _class: #
.. _DateTime: #
.. _int: #
.. _integer: #
.. _mixed: #
.. _number: #
.. _object: #
.. _regex: #
.. _string: #
