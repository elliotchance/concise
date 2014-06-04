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
}
