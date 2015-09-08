<?php

namespace Concise\Services;

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
        $this->aassert($this->descriptor->describe('abc'))->equals('string');
    }

    public function testDescriptionOfInteger()
    {
        $this->aassert($this->descriptor->describe(123))->equals('integer');
    }

    public function testDescriptionOfDouble()
    {
        $this->aassert($this->descriptor->describe(1.23))->equals('double');
    }

    public function testDescriptionOfArray()
    {
        $this->aassert($this->descriptor->describe(array()))->equals('array');
    }

    public function testDescriptionOfObject()
    {
        $this->aassert($this->descriptor->describe($this))->equals('Concise\Services\ValueDescriptorTest');
    }

    public function testDescriptionOfResource()
    {
        $this->aassert($this->descriptor->describe(fopen('.', 'r')))
            ->equals('resource');
    }
}
