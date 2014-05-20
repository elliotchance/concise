<?php

namespace Concise\Syntax;

use \Concise\TestCase;

class CodeTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->code = new Code('abc');
	}

	public function testCodeIsSetInConstructor()
	{
		$this->assertEquals('abc', $this->code->getCode());
	}

	public function testCastingToStringIsTheSameAsGetCode()
	{
		$this->assertEquals('abc', (string) $this->code);
	}
}
