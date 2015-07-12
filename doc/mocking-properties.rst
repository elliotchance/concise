Properties
----------

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
