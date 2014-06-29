<?php

namespace Concise\Mock\Action;

use \Concise\TestCase;

class NoActionTest extends TestCase
{
	/**
	 * @expectedException Exception
	 * @expectedExceptionMessage You cannot render an action from NoAction.
	 */
	public function testTryingToWillActionWillThrowAnException()
	{
		$noAction = new NoAction();
		$noAction->getWillAction($this);
	}
}
