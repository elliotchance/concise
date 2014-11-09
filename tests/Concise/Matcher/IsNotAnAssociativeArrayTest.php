<?php

namespace Concise\Matcher;

class IsNotAnAssociativeArrayTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsAnAssociativeArray();
    }

    public function testAnAssociativeArrayContainsAtLeastOneKeyThatsNotANumber()
    {
        $x = array(
            "a" => 123,
            0 => "foo",
        );
        $this->assertFailure($x, is_not_an_associative_array);
    }

    public function testAnArrayIsAssociativeIfAllIndexesAreIntegersButNotZeroIndexed()
    {
        $x = array(
            5 => 123,
            10 => "foo",
        );
        $this->assertFailure($x, is_not_an_associative_array);
    }

    public function testAnArrayIsNotAssociativeIfZeroIndexed()
    {
        $this->assert('[1,"foo"] is not an associative array');
    }

    public function tags()
    {
        return array(Tag::ARRAYS, Tag::TYPES);
    }
}
