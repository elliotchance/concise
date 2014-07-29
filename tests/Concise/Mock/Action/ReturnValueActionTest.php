<?php

namespace Concise\Mock\Action;

use Concise\TestCase;

class ReturnValueActionTest extends TestCase
{
	public function testObjectReturnedInAnotherNamespaceIsCompatible()
	{
		$myObject = new \stdClass();
		$value = new ReturnValueAction($myObject);
		$result = eval($value->getActionCode());
		$this->assert($myObject, is_the_same_as, $result);
	}
}
