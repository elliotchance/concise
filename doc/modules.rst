Modules
=======

Modules contain assertions. If you need to create your own assertions you will
likely want to create one or more modules.


Creating a Module
-----------------

Each module is a class that extends ``Concise\Module\AbstractModule`` and
contains methods that are annotated with the `syntaxes`_ they will match on, for
example:

.. _syntaxes: syntaxes.html

.. code-block:: php

   class UrlModule extends \Concise\Module\AbstractModule
   {
       public function getName()
       {
           return "URLs";
       }

       /**
        * Validate URL.
        *
        * @syntax url ?:string is valid
        */
       public function urlIsValid()
       {
           $this->failIf(
               filter_var($this->data[0], FILTER_VALIDATE_URL) === false
           );
       }
   }

Methods in a module can have zero or more ``@syntax`` annotations. You may use
``fail()`` or ``failIf(bool)`` to throw failures. Any value returned will be
returned as-is to be used in nested assertions.


Loading a Module
----------------

Modules can be loaded through the ``ModuleManager`` like:

.. code-block:: php

   ModuleManager::getInstance()->loadModule(new MyModule());

Some things to note:

 * It is safe to load the same module multiple times. Internally modules are
   identified by their class name so loading the same module will be ignored.

 * Once modules are loaded into the ``ModuleManager`` they remain there for the
   entire run. If you had a bootstrap file for your test suite it would be a
   good idea to load your modules here, otherwise putting them in the
   appropriate test cases is fine too.


Testing Modules
---------------

Use the ``Concise\Module\AbstractModuleTestCase`` when testing modules:

.. code-block:: php

   class MyModuleTest extends AbstractMatcherTestCase
   {
       public function setUp()
       {
           parent::setUp();
           $this->module = new MyModule();
       }

       public function testIntegerIsAnInteger()
       {
           $this->assert(123)->isAnInteger;
       }

       /**
        * @expectedException @expectedException \Concise\Core\DidNotMatchException
        */
       public function testFloatIsNotAnInteger()
       {
           $this->assert(123.0)->isAnInteger;
       }
   }


IDE and Code Completion
-----------------------

Once modules are loaded in (as described in *Loading a Module*) all
functionailty will work as expected. However, to get code completion in your
favourite IDE you will need to refresh the BaseAssertions that the IDE has used
to pick up the known modules.

Bundled with concise is a command called ``concise-init`` that will do just
that. It is safe to run this as frequently as you need.

By default the original ``BaseAssertions.php`` is modified. However, there are
some cases where you want this file to be located somewhere else. To allow this
you can set the environment variable ``CONCISE_BASEASSERTIONS`` to another file.

.. code-block:: bash

   export CONCISE_BASEASSERTIONS=/tmp/BaseAssertions.php

**Note:** You will need to put this file somewhere your IDE will index but
should not be committed to your application repository. A temporary build
directory containing other generated content that is ignored by your version
control is common.
