<?php

namespace Concise\Matcher;

use \Concise\TestCase;
use \Concise\Syntax\MatcherParser;

class MyMatcher extends AbstractMatcher
{
	public function match($syntax, array $data = array())
	{
		return false;
	}

	public function supportedSyntaxes()
	{
		return array();
	}

	public function getComparer()
	{
		return parent::getComparer();
	}
}

class AbstractMatcherTest extends TestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->matcher = new MyMatcher();
	}

	public function testDefaultRendererWorks()
	{
		$this->assertEquals('', $this->matcher->renderFailureMessage(''));
	}

	public function _test_has_access_to_comparer()
	{
		return '`$self->matcher->getComparer()` is instance of \Concise\Services\Comparer';
	}
}
