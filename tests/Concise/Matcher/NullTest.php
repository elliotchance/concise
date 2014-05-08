<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class NullTest extends AbstractMatcherTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new Null();
	}

	public function _test_comparisons()
	{
		$this->x = null;
		$this->y = 'a';
		return array(
			'x is null',
			'y is not null',
			'"null" is not null',
			'"" is not null',
		);
	}

	public function failedMessages()
	{
		return array(
			array('? is null', array(false), 'expected null'),
			array('? is not null', array(null), 'expected not null'),
		);
	}
}
