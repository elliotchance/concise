Running Tests
=============

The Concise CLI
---------------

Concise comes with a CLI that acts as a wrapper for the original ``phpunit``
command. You may use all the available options of ``phpunit``, however the
``concise`` executable offers a few more and has a much nicer result printer.

Likewise you can still run pure concise tests through the ``phpunit`` runner.
Which is handy for existing CI systems.

Continuous Integration (CI)
---------------------------

The default result printer will likely not work so well with your CI and other
non-interactive systems. There are several solutions for this;

1. You may continue to use the ``phpunit`` executable and printer which will
   work exactly like you expect it to.

2. There is an option for concise to use an alternate printer used for CI:
   ``--ci``. This will hide the progress bar and only update progress line no
   more than once each percentage.

   The advantage of this over the traiditional ``phpunit`` executable is you
   will be able to see failures as they happen, rather than waiting till the
   end of the run.
