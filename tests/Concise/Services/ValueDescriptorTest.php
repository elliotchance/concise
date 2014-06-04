<?php

namespace Concise\Services;

class ValueDescriptorTest extends \Concise\TestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->descriptor = new ValueDescriptor();
	}

	public function testDescriptionOfString()
	{
		$this->assertSame('string', $this->descriptor->describe('abc'));
	}

	public function testDescriptionOfInteger()
	{
		$this->assertSame('integer', $this->descriptor->describe(123));
	}

	public function testDescriptionOfDouble()
	{
		$this->assertSame('double', $this->descriptor->describe(1.23));
	}

	public function testDescriptionOfArray()
	{
		$this->assertSame('array', $this->descriptor->describe(array()));
	}

	public function testDescriptionOfObject()
	{
		$this->assertSame('Concise\Services\ValueDescriptorTest', $this->descriptor->describe($this));
	}

	public function testDescriptionOfResource()
	{
		$this->assertSame('resource', $this->descriptor->describe(fopen('.', 'r')));
	}
}
