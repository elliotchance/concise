<?php

namespace Concise\Services;

class ValueDescriptorTest extends \Concise\TestCase
{
	public function testDescriptionOfString()
	{
		$this->descriptor = new ValueDescriptor();
		$this->assertSame('string', $this->descriptor->describe('abc'));
	}
}
