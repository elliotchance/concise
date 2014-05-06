<?php

namespace Concise;

class Assertion
{
	public function __construct($assertion)
	{
		$this->assertion = $assertion;
	}
	
	public function getAssertion()
	{
		return $this->assertion;
	}
}
