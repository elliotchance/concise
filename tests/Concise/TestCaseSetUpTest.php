<?php

namespace Concise;

class TestCaseSetUpTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->xyz = 456;
	}

	public function testCanUseAttributesSetInSetUp()
	{
		$this->assert('xyz equals 456');
	}
}
