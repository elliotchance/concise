<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	protected $data = array();

	public function getData()
	{
		return $this->data;
	}

	public function setData(array $data)
	{
		$this->data = $data;
	}
}
