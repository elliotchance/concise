<?php

namespace Concise\Services;

class MatcherSyntaxAndDescriptionTest extends \Concise\TestCase
{
	public function testNoDescriptions()
	{
		$data = array(
			'? equals ?',
			'? is equal to ?'
		);
		$service = new MatcherSyntaxAndDescription();
		$result = $service->process($data);
		$this->assertSame(array(
			'? equals ?'      => null,
			'? is equal to ?' => null
		), $result);
	}
}
