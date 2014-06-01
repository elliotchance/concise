<?php

namespace Concise\Matcher;

class FalseTest extends AbstractMatcherTestCase
{
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new False();
	}

	public function testAlwaysFails()
	{
		$this->assertMatcherFailure('false');
	}
}
