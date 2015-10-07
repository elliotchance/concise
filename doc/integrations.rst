Integrations
============

Pho
---

`Pho`_ is a `BDD`_ test framework for PHP, inspired by `Jasmine`_ and `RSpec`_.

The ``concise`` command-line runner supports running Pho tests without any
modification of the specs themselfs: However, you must setup the correct test
suite loader class in your ``phpunit.xml``:

.. code-block:: xml

   <phpunit
        ...
        testSuiteLoaderFile="src/Concise/Extensions/Pho/PhoTestSuiteLoader.php"
        testSuiteLoaderClass="Concise\Extensions\Pho\PhoTestSuiteLoader">

As far as I'm aware both of these need to be set and that can only be done
through the XML configuration and not the CLI interface. Below it highlights
some of the features that do not work for Pho through the XML configuration.

Running a single spec file:

.. code-block:: bash

   vendor/bin/concise path/to/SomethingSpec.php

You may also load a whole directory of recursive specs:

.. code-block:: bash

   vendor/bin/concise --test-suffix=Spec.php path/to/spec

**Note:** In this case of loading a folder you must specify the
``--test-suffix`` otherwise PHPUnit's internal directory iterator will ignore
any file that does not end with the default suffix ``Test.php``.

One requirement of all PHPUnit test cases is that it knows how many total test
cases exist before the test cases start running. Concise will work out how many
test cases (designated by the ``it()``) are in the file when it is loaded
without having to execute the test suite.

Using other test result formats:

.. code-block:: bash

   vendor/bin/concise --log-junit junit.xml --test-suffix=Spec.php path/to/spec

The `entire Pho test`_ suite is run under concise as part of the main build
system.

.. _entire Pho test: https://travis-ci.org/elliotchance/concise


What Doesn't Work
~~~~~~~~~~~~~~~~~

Due to the way PHPUnit loads in test cases into a static context you cannot use
the same Pho test loader with the ``phpunit`` command. Concise must override
chunks of PHPUnit to allow the test cases to be loaded correctly.

The XML configuration file cannot be used to load the spec files and folders
for the same reason. It would take a lot more code to allow this to work.
However, it could be fixed in the future. You should specify the spec folder in
the ``concise`` command line to trigger the correct loading of the test files.

Code coverage my not work as expected. I'm not sure why this is, please let me
know if you get this working.

PHP 5.6 does work (it will report errors on failures) however the total test
count is not applied correctly. See `Pho on 5.6 not working`_.

.. _Pho on 5.6 not working: https://github.com/elliotchance/concise/issues/301
.. _BDD: https://en.wikipedia.org/wiki/Behavior-driven_development
.. _Pho: https://github.com/danielstjules/pho
.. _Jasmine: http://jasmine.github.io
.. _RSpec: http://rspec.info


PHPUnit
-------

Concise is built on top of PHPUnit and all the features available in PHPUnit
will work with concise.

Native features of PHPUnit (4.0 and above) that do not work as expected should
be reported as a bug.


Other Frameworks
----------------

Concise can also be used by any other frameworks by simply instantiating and
managing the ``Concise\Core\TestCase`` yourself:

.. code-block:: php

   use \Concise\Core\TestCase;

   class MyTinyTestSuite
   {
       protected $testCase;

       public function __construct()
       {
           $this->testCase = new TestCase();
       }

       public function checkSomething()
       {
           $this->testCase->setUp();
           $this->testCase->assert(3 + 5)->equals(8);
           $this->testCase->tearDown();
       }
   }

Since Concise implicitly expects ``setUp()`` and ``tearDown()`` methods to be
called at appropriate times but does not enforce this behaviour - if you use it
differently then it may do unexpected things.
