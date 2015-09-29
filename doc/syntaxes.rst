Syntaxes
========

What is a Syntax?
-----------------

A *syntax* explains how an assertion gets translated for a matcher. A simple
example is::

    ? equals ?

Which can be used in your test:

.. code-block:: php

   $this->assert(123)->equals(456);

So the syntax ``? equals ?`` matches with two data items; ``123`` and ``456``.

Syntaxes can contain multiple words in a row::

    ? is greater than ?

Which can be used the same way as:

.. code-block:: php

   $this->assert(123)->isGreaterThan(456);

Syntaxes can contain as many data points as you need::

    ? is within ? of ?

.. code-block:: php

   $this->assert(1)->isWithin(0.2)->of(0.9);

And finally the syntax can start with a data element or not::

    date ? is after ?

.. code-block:: php

   $this->assertDate($foo)->isAfter(time());


Restricting Data Types
----------------------

In a lot of cases it only makes sense for an assertion to work with known data
types, for example::

    ? starts with ?

Here we are talking about strings. If someone were to put through a type that
doesn't make sense or cannot be computed like:

.. code-block:: php

   $this->assert(new stdClass())->startsWith(true);

We would no doubt get some error, or at the very least the assertion would
return an unreliable result.

There are two ways to mitigate this:

 1. Do the type checking yourself in the matcher class by checking each data
    element for a sane type.

 2. Use the syntax to specify the allowed types. This is must easer::

    ?:string starts with ?:string

Now concise will do the type checking for us. If we get some bad types it will
throw an exception explaining the error and never need to the call the actual
matcher. It also means that your matcher class can guarantee that the data
elements taken in are both strings.

More complex requirements can be specified by separating with a comma::

    ?:int,float is greater than ?:int,float

Or, the reverse logic can be used to blacklist types (instead of whitelist)
them::

    ?:!object is scalar

Will accept any type that is *not* an ``object``.


Special Data Types
------------------

Due to PHP's relaxed typing we want to be sure we don't potentially run into
this problem:

.. code-block:: php

   $this->assert('123')->isGreaterThan(1.23);

This will fail because ``'123'`` is a string, but it can also be treated as a
number. So concise provides some special types that do value checking as well::

    ?:number is greater than ?:number

We can now safely use number-like values:

.. code-block:: php

   $this->assert('123')->isGreaterThan(1.23); // numbers
   $this->assert('foo')->isGreaterThan(1.23); // 'foo' is not a number

See the table below for all the supported types:

+--------------+-----------------------------------+
| Type         | Example values                    |
+==============+===================================+
| ``int``      | ``123``                           |
+--------------+                                   |
| ``integer``  |                                   |
+--------------+-----------------------------------+
| ``float``    | ``1.23``                          |
+--------------+                                   |
| ``double``   |                                   |
+--------------+-----------------------------------+
| ``string``   | ``"abc"``                         |
+--------------+-----------------------------------+
| ``array``    | ``array()``                       |
+--------------+-----------------------------------+
| ``resource`` | ``fopen('.', 'r')``               |
+--------------+-----------------------------------+
| ``object``   | ``new \stdClass()``               |
+--------------+-----------------------------------+
| ``callable`` | ``function () { }``               |
+--------------+-----------------------------------+
| ``regex``    | ``"/foo/"``                       |
+--------------+-----------------------------------+
| ``class``    | ``"Concise\Core\TestCase"``       |
+--------------+-----------------------------------+
| ``number``   | ``123``, ``1.23``, ``"12.3"``     |
+--------------+-----------------------------------+
| ``bool``     | ``true``                          |
+--------------+-----------------------------------+

Separately from the type names in the table you may also specify specific
classes::

    ?:DateTime is a date
    ?:\DateTime is a date

Subclasses are allowed.
