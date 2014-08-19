<?php

namespace Concise\Mock;

use \Concise\TestCase;

abstract class AbstractMockBuilderTestCase extends TestCase
{
    public function testMockCanBeCreatedFromAnObjectThatExists()
    {
        $mock = $this->mock($this->getClassName())
                     ->done();
        $this->assert($mock, instance_of, $this->getClassName());
    }

    abstract public function getClassName();
}
