#!/bin/bash

export CONCISE_BIN="vendor/bin/concise -c tests/Concise/Extensions/Pho/phpunit.xml"

# Run a single spec file
$CONCISE_BIN vendor/danielstjules/pho/spec/Expectation/ExpectationSpec.php
$CONCISE_BIN --ci vendor/danielstjules/pho/spec/Expectation/ExpectationSpec.php > tests/Concise/Extensions/Pho/travis_1.txt
cat tests/Concise/Extensions/Pho/travis_1.txt

# Running a folder containing specs
$CONCISE_BIN --ci --test-suffix=Spec.php vendor/danielstjules/pho/spec > tests/Concise/Extensions/Pho/travis_2.txt
cat tests/Concise/Extensions/Pho/travis_2.txt
