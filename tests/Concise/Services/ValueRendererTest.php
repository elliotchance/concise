<?php

namespace Concise\Services;

class ValueRendererTest extends \PHPUnit_Framework_TestCase
{
	public function testIntegerValueRendersWithoutModification()
	{
		$renderer = new ValueRenderer();
		$this->assertSame('123', $renderer->render(123));
	}

	public function testFloatingPointValueRendersWithoutModification()
	{
		$renderer = new ValueRenderer();
		$this->assertSame('1.23', $renderer->render(1.23));
	}
}
