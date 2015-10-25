Assertions
==========

.. start matchers

Arrays
------

* array `array`_ count is `int`_ -  Assert an array has a specific number of elements.   
* array `array`_ count is not `int`_ -  Assert an array does not have a specific number of elements.   
* array `array`_ does not have item `array`_ -  Assert an array does not have key and value item.   
* array `array`_ does not have key `int`_\|\ `string`_ -  Assert an array does not have a key.   
* array `array`_ does not have keys `array`_ -   
* array `array`_ does not have value `mixed`_ -  Assert an array does not have any occurrences of the given value.   
* array `array`_ has item `array`_ -  Assert an array has key and value item.   
* array `array`_ has items `array`_ -  Assert an array has all key and value items.   
* array `array`_ has key `int`_\|\ `string`_ -  Assert an array has key, returns value.   
* array `array`_ has keys `array`_ -  Assert an array has several keys in any order.   
* array `array`_ has value `mixed`_ -  Assert an array has at least one occurrence of the given value.   
* array `array`_ has values `array`_ -  Assert an array has several values in any order.   
* array `array`_ is associative -  Assert an array is associative.   
* array `array`_ is empty -  Assert an array is empty (no elements).   
* array `array`_ is not associative -  Assert an array is not associative.   
* array `array`_ is not empty -  Assert an array is not empty (at least one element).   
* array `array`_ is not unique -  Assert that an array only has at least one element that is repeated.   
* array `array`_ is unique -  Assert that an array only contains unique values.   

Basic
-----

* `mixed`_ does not equal `mixed`_ -  Assert two value do not match with no regard to type.   
* `mixed`_ does not exactly equal `mixed`_ -  Assert two values are of exactly the same type and value.   
* `mixed`_ equals `mixed`_ -  Assert values with no regard to exact data types.   
* `mixed`_ exactly equals `mixed`_ -  Assert two values match data type and value.   
* `mixed`_ is not the same as `mixed`_ -  Assert two values are of exactly the same type and value.   
* `mixed`_ is the same as `mixed`_ -  Assert two values match data type and value.   

Booleans
--------

* `mixed`_ is false -  Assert value is false.   
* `mixed`_ is falsy -  Assert a value is a false-like value.   
* `mixed`_ is true -  Assert a value is true.   
* `mixed`_ is truthy -  Assert a value is a non false-like value.   

Date and Time
-------------

* date `int`_\|\ `string`_\|\ `DateTime`_ is after `int`_\|\ `string`_\|\ `DateTime`_ -  A date/time is after another date/time, returns original date in the same format as provided.   
* date `int`_\|\ `string`_\|\ `DateTime`_ is before `int`_\|\ `string`_\|\ `DateTime`_ -  A date/time is before another date/time, returns original date in the same format as provided.   

Exceptions
----------

* closure `callable`_ does not throw `class`_ -  Assert that a specific exception is not thrown.   
* closure `callable`_ does not throw exception -  Assert that no exception is thrown.   
* closure `callable`_ throws `class`_ -  Assert a specific exception was thrown.   
* closure `callable`_ throws anything except `class`_ -  Assert any exception except a specific one was thrown.   
* closure `callable`_ throws exactly `class`_ -  Assert a specific exception was thrown.   
* closure `callable`_ throws exception -  Assert an exception was thrown.   

Files
-----

* file `string`_ does not equal `string`_ -  Compare string value with the contents of a file.   
* file `string`_ equals `string`_ -  Compare string value with the contents of a file.   

Hashing (Cryptography)
----------------------

* hash `mixed`_ is a valid adler32 -  Assert hash is an 8 digit hexadecimal.   
* hash `mixed`_ is a valid crc32 -  Assert hash is an 8 digit hexadecimal.   
* hash `mixed`_ is a valid crc32b -  Assert hash is an 8 digit hexadecimal.   
* hash `mixed`_ is a valid fnv132 -  Assert hash is an 8 digit hexadecimal.   
* hash `mixed`_ is a valid fnv164 -  Assert hash is a 16 digit hexadecimal.   
* hash `mixed`_ is a valid gost -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid haval128 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid haval160 -  Assert hash is a 40 digit hexadecimal.   
* hash `mixed`_ is a valid haval192 -  Assert hash is a 48 digit hexadecimal.   
* hash `mixed`_ is a valid haval224 -  Assert hash is a 56 digit hexadecimal.   
* hash `mixed`_ is a valid haval256 -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid joaat -  Assert hash is an 8 digit hexadecimal.   
* hash `mixed`_ is a valid md2 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid md4 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid md5 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid ripemd128 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid ripemd160 -  Assert hash is a 40 digit hexadecimal.   
* hash `mixed`_ is a valid ripemd256 -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid ripemd320 -  Assert hash is an 80 digit hexadecimal.   
* hash `mixed`_ is a valid sha1 -  Assert hash is a 40 digit hexadecimal.   
* hash `mixed`_ is a valid sha224 -  Assert hash is a 56 digit hexadecimal.   
* hash `mixed`_ is a valid sha256 -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid sha384 -  Assert hash is a 96 digit hexadecimal.   
* hash `mixed`_ is a valid sha512 -  Assert hash is a 128 digit hexadecimal.   
* hash `mixed`_ is a valid snefru -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid snefru256 -  Assert hash is a 64 digit hexadecimal.   
* hash `mixed`_ is a valid tiger128 -  Assert hash is a 32 digit hexadecimal.   
* hash `mixed`_ is a valid tiger160 -  Assert hash is a 40 digit hexadecimal.   
* hash `mixed`_ is a valid tiger192 -  Assert hash is a 48 digit hexadecimal.   
* hash `mixed`_ is a valid whirlpool -  Assert hash is a 128 digit hexadecimal.   
* hash `mixed`_ is not a valid adler32 -  Assert hash is not an 8 digit hexadecimal.   
* hash `mixed`_ is not a valid crc32 -  Assert hash is not an 8 digit hexadecimal.   
* hash `mixed`_ is not a valid crc32b -  Assert hash is not an 8 digit hexadecimal.   
* hash `mixed`_ is not a valid fnv132 -  Assert hash is not an 8 digit hexadecimal.   
* hash `mixed`_ is not a valid fnv164 -  Assert hash is not a 16 digit hexadecimal.   
* hash `mixed`_ is not a valid gost -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid haval128 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid haval160 -  Assert hash is not a 40 digit hexadecimal.   
* hash `mixed`_ is not a valid haval192 -  Assert hash is not a 48 digit hexadecimal.   
* hash `mixed`_ is not a valid haval224 -  Assert hash is not a 56 digit hexadecimal.   
* hash `mixed`_ is not a valid haval256 -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid joaat -  Assert hash is not an 8 digit hexadecimal.   
* hash `mixed`_ is not a valid md2 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid md4 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid md5 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid ripemd128 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid ripemd160 -  Assert hash is not a 40 digit hexadecimal.   
* hash `mixed`_ is not a valid ripemd256 -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid ripemd320 -  Assert hash is not a 80 digit hexadecimal.   
* hash `mixed`_ is not a valid sha1 -  Assert hash is not a 40 digit hexadecimal.   
* hash `mixed`_ is not a valid sha224 -  Assert hash is not a 56 digit hexadecimal.   
* hash `mixed`_ is not a valid sha256 -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid sha384 -  Assert hash is not a 96 digit hexadecimal.   
* hash `mixed`_ is not a valid sha512 -  Assert hash is not a 128 digit hexadecimal.   
* hash `mixed`_ is not a valid snefru -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid snefru256 -  Assert hash is not a 64 digit hexadecimal.   
* hash `mixed`_ is not a valid tiger128 -  Assert hash is not a 32 digit hexadecimal.   
* hash `mixed`_ is not a valid tiger160 -  Assert hash is not a 40 digit hexadecimal.   
* hash `mixed`_ is not a valid tiger192 -  Assert hash is not a 48 digit hexadecimal.   
* hash `mixed`_ is not a valid whirlpool -  Assert hash is not a 128 digit hexadecimal.   

Numbers
-------

* `number`_ is between `number`_ and `number`_ -  A number must be between two values (inclusive), returns value.   
* `number`_ is greater than `number`_ -  A number is greater than another number.   
* `number`_ is greater than or equal to `number`_ -  A number is greater than or equal to another number.   
* `number`_ is less than `number`_ -  A number is less than another number.   
* `number`_ is less than or equal to `number`_ -  A number is less than or equal to another number.   
* `number`_ is not between `number`_ and `number`_ -  A number must not be between two values (inclusive).   
* `number`_ is not within `number`_ of `number`_ -  Assert two values are not close to each other.   
* `number`_ is within `number`_ of `number`_ -  Assert two values are close to each other.   

Objects and Classes
-------------------

* `object`_\|\ `class`_ is an instance of `class`_ -  Assert an objects class or subclass.   
* `object`_\|\ `class`_ is not an instance of `class`_ -  Assert than an object is not a class or subclass.   
* object `object`_ does not have property `string`_ -  Assert that an object does not have a property.   
* object `object`_ has property `string`_ -  Assert that an object has a property. Returns the properties value.   

Regular Expressions
-------------------

* string `string`_ does not match `regex`_ -  Assert that a string does not match a regular expression.   
* string `string`_ matches `regex`_ -  Assert that a string matches a regular expression.   

Strings
-------

* string `mixed`_ does not end with `mixed`_ -  Assert a string does not end with another string.   
* string `mixed`_ does not start with `mixed`_ -  Assert a string does not not start (begin) with another string.   
* string `string`_ contains `string`_ -  A string contains a substring. Returns original string.   
* string `string`_ contains case insensitive `string`_ -  A string contains a substring (ignoring case-sensitivity). Returns original string.   
* string `string`_ does not contain `string`_ -  A string does not contain a substring. Returns original string.   
* string `string`_ does not contain case insensitive `string`_ -  A string does not contain a substring (ignoring case-sensitivity). Returns original string.   
* string `string`_ ends with `string`_ -  Assert a string ends with another string.   
* string `string`_ is empty -  Assert a string is zero length.   
* string `string`_ is not empty -  Assert a string has at least one character.   
* string `string`_ starts with `string`_ -  Assert a string starts (begins) with another string.   

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
