<?php

namespace Concise\Matcher;

abstract class AbstractMatcher
{
	protected $data = array(
		'a' => 123,
		'b' => '456'
	);

	public function getData()
	{
		return $this->data;
	}
}
