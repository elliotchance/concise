#!/bin/bash

set -x

export CONCISE_BIN="bin/concise -c tests/Concise/Extensions/Pho/phpunit.xml"

# Run a single spec file
$CONCISE_BIN --ci vendor/danielstjules/pho/spec/Expectation/ExpectationSpec.php > tests/Concise/Extensions/Pho/travis_1.txt
cat tests/Concise/Extensions/Pho/travis_1.txt

# Running a folder containing specs
$CONCISE_BIN --ci --test-suffix=Spec.php vendor/danielstjules/pho/spec > tests/Concise/Extensions/Pho/travis_2.txt
cat tests/Concise/Extensions/Pho/travis_2.txt

# Make sure the outputs are good
MD51=`cat tests/Concise/Extensions/Pho/travis_1.txt | md5sum`
MD52=`cat tests/Concise/Extensions/Pho/travis_1_expected.txt | md5sum`
if [ "$MD51" != "$MD52" ]; then
    diff tests/Concise/Extensions/Pho/travis_1.txt tests/Concise/Extensions/Pho/travis_1_expected.txt
    exit 1
fi

MD51=`cat tests/Concise/Extensions/Pho/travis_2.txt | md5sum`
MD52=`cat tests/Concise/Extensions/Pho/travis_2_expected.txt | md5sum`
if [ "$MD51" != "$MD52" ]; then
    diff tests/Concise/Extensions/Pho/travis_2.txt tests/Concise/Extensions/Pho/travis_2_expected.txt
    exit 2
fi
