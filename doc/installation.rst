Installation
============

Requirements
------------

Concise requires PHPUnit which is included as a dependency of concise. Concise
is compatable and tested against all minor releases of PHPUnit starting with
with 4.0. Builds can be found at `Travis CI`_ with different ``COMPOSER``
values.

PHP versions `5.3 to 5.6`_ are supported. However, `HHVM is not yet supported`_.

.. _Travis CI: https://travis-ci.org/elliotchance/concise
.. _5.3 to 5.6: https://travis-ci.org/elliotchance/concise
.. _HHVM is not yet supported: https://github.com/elliotchance/concise/pull/223

Composer
--------

Concise is provided through `Composer`_. The easiest way to include concise as
a development dependency for your current project:

.. code-block:: bash

   composer require-dev elliotchance/concise

Alternatively you can add it to your ``composer.json`` file:

.. code-block:: json

   {
       "require-dev": {
           "elliotchance/concise": "~2.0"
       }
   }

.. _Composer: https://getcomposer.org
