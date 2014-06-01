<?php

namespace Concise\Services;

use \Concise\TestCase;

class SyntaxRendererTest extends TestCase
{
	protected $renderer;

	public function setUp()
	{
		parent::setUp();
		$this->renderer = new SyntaxRenderer();
	}

	public function testCanSubstituteValuesFromArrayIntoPlaceholders()
	{
		$data = array(1, '2', 3.1);
		$this->assertEquals('1 is "2" bla 3.1', $this->renderer->render('? is ? bla ?', $data));
	}
}
