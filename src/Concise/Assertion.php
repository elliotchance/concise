<?php

namespace Concise;

class Assertion
{
	protected $assertion;

	protected $data = array();

	public function __construct($assertion, array $data = array())
	{
		$this->assertion = $assertion;
		$this->data = $data;
	}
	
	public function getAssertion()
	{
		return $this->assertion;
	}
	
	public function getData()
	{
		return $this->data;
	}
}
