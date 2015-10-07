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
MD51=`md5sum --quiet tests/Concise/Extensions/Pho/travis_1.txt`
MD52=`md5sum --quiet tests/Concise/Extensions/Pho/travis_1_expected.txt`
if [ "$MD51" != "$MD52" ]; then
    exit 1
fi

MD51=`md5sum --quiet tests/Concise/Extensions/Pho/travis_2.txt`
MD52=`md5sum --quiet tests/Concise/Extensions/Pho/travis_2_expected.txt`
if [ "$MD51" != "$MD52" ]; then
    exit 2
fi
