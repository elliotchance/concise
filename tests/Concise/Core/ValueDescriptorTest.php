<?php

namespace Concise\Core;

use Concise\TestCase;

class ValueDescriptorTest extends TestCase
{
    /** @var ValueDescriptor */
    protected $descriptor;

    public function setUp()
    {
        parent::setUp();
        $this->descriptor = new ValueDescriptor();
    }

    public function testDescriptionOfString()
    {
        $this->assert($this->descriptor->describe('abc'))->equals('string');
    }

    public function testDescriptionOfInteger()
    {
        $this->assert($this->descriptor->describe(123))->equals('integer');
    }

    public function testDescriptionOfDouble()
    {
        $this->assert($this->descriptor->describe(1.23))->equals('double');
    }

    public function testDescriptionOfArray()
    {
        $this->assert($this->descriptor->describe(array()))->equals('array');
    }

    public function testDescriptionOfObject()
    {
        $this->assert($this->descriptor->describe($this))
            ->equals('Concise\Core\ValueDescriptorTest');
    }

    public function testDescriptionOfResource()
    {
        $this->assert($this->descriptor->describe(fopen('.', 'r')))
            ->equals('resource');
    }
}
