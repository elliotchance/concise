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
	public function prepare()
	{
		parent::prepare();
		$this->matcher = new MyMatcher();
	}

	public function testDefaultRendererWorks()
	{
		$this->assertEquals('', $this->matcher->renderFailureMessage(''));
	}

	public function testHasAccessToComparer()
	{
		$this->assertInstanceOf('\Concise\Services\Comparer', $this->matcher->getComparer());
	}
}
