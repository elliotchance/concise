<?php

namespace Concise;

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
		$this->assertEquals('1 is 2 bla 3.1', $this->renderer->render('? is ? bla ?', $data));
	}

	public function singlePlaceholders()
	{
		return array(
			'true' => array(true, 'true'),
			'false' => array(false, 'false'),
			'integer' => array(123, '123'),
		);
	}

	/**
	 * @dataProvider singlePlaceholders
	 */
	public function testRenderValue($value, $expected)
	{
		$this->assertEquals($expected, $this->renderer->renderValue($value));
	}
}
