<?php

namespace Concise;

class SyntaxRendererTest extends TestCase
{
	public function testCanSubstituteValuesFromArrayIntoPlaceholders()
	{
		$data = array(1, '2', 3.1);
		$renderer = new SyntaxRenderer();
		$this->assertEquals('1 is 2 bla 3.1', $renderer->render('? is ? bla ?', $data));
	}
}
