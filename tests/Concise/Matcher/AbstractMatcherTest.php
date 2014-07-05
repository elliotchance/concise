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
		$this->assert($this->matcher->renderFailureMessage(''), is_blank);
	}
}
