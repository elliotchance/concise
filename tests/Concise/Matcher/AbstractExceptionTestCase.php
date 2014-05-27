<?php

namespace Concise\Matcher;

use \Concise\TestCase;

class AbstractExceptionTestCase extends AbstractMatcherTestCase
{
	/**
	 * @expectedException \Exception
	 * @expectedExcatpionMessage The attribute to test for exception must be callable (an anonymous function)
	 */
	public function testMatcherWillOnlyAcceptCallable()
	{
		$this->matcher->match('', array(123));
	}
}
