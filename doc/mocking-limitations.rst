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
