#!/bin/bash

# Run a single spec file
vendor/bin/concise vendor/danielstjules/pho/spec/Expectation/ExpectationSpec.php
vendor/bin/concise --ci vendor/danielstjules/pho/spec/Expectation/ExpectationSpec.php > tests/Concise/Extensions/Pho/travis_1.txt

# Running a folder containing specs
vendor/bin/concise --ci --test-suffix=Spec.php vendor/danielstjules/pho/spec/Expectation > tests/Concise/Extensions/Pho/travis_2.txt

# Using configuration
vendor/bin/concise --ci -c tests/Concise/Extensions/Pho/phpunit.xml > tests/Concise/Extensions/Pho/travis_3.txt
