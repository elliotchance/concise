<?php

namespace Concise\Matcher;

class IsNotAnEmptyArrayTest extends AbstractMatcherTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->matcher = new IsNotAnEmptyArray();
    }

    public function testArrayWithZeroElements()
    {
        $this->assertFailure(array(), is_not_empty_array);
    }

    public function testArrayWithMoreThanZeroElements()
    {
        $this->assert(array('a'), is_not_empty_array);
    }

    public function tags()
    {
        return array(Tag::ARRAYS);
    }
}
