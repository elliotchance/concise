concise
=======

.. image:: https://travis-ci.org/elliotchance/concise.svg?branch=master
   :target: https://travis-ci.org/elliotchance/concise
.. image:: https://img.shields.io/coveralls/elliotchance/concise.svg
   :target: https://coveralls.io/r/elliotchance/concise?branch=master
.. image:: https://poser.pugx.org/elliotchance/concise/v/stable.svg
   :target: https://packagist.org/packages/elliotchance/concise
.. image:: https://poser.pugx.org/elliotchance/concise/downloads.svg
   :target: https://packagist.org/packages/elliotchance/concise

Concise is unit testing framework that uses plain English and minimal code. It
extends and is fully compatible with existing PHPUnit projects.

.. image:: https://raw.githubusercontent.com/wiki/elliotchance/concise/image-concise-command.png

Highlights include:

 * 100% compatible with PHPUnit, no changes required. You may use as many
   features as you wish.
 * Much better `mocking framework`_ with a lot less typing.
 * Huge array of `assertions`_ to save on boilerplate code.
 * Assert and `verify`_ are supported.

.. _verify: writing-tests.html#verify-vs-assert
.. _mocking framework: mocking.html
.. _assertions: matchers.html

.. toctree::
   :maxdepth: 2
   :numbered:

   installation
   writing-tests
   assertions
   running-tests
   mocking
   syntaxes
   modules
   integrations
   changelog
