<?php

namespace Concise;

class TestCaseMockTest extends TestCase
{
	public function testCreateMockStillOperatesCorrectly()
	{
		$mock = $this->getMock('\stdClass', array('mymethod'));
		$mock->expects($this->any())
		     ->method('mymethod')
		     ->will($this->returnValue(123));
		$this->assertSame(123, $mock->mymethod());
	}
}
