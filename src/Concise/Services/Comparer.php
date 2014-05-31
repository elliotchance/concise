<?php

namespace Concise\Services;

use \Concise\Services\ConvertToString;

class Comparer
{
	protected $convertToString;

	public function __construct()
	{
		$this->convertToString = new ConvertToString;
	}

	public function setConvertToString(ConvertToString $convertToString)
	{
		$this->convertToString = $convertToString;
	}

	protected function normalize($value)
	{
		if(!is_resource($value) && !is_bool($value) && !is_null($value)) {
			$value = $this->convertToString->convertToString($value);
		}
		return $value;
	}

	public function compare($a, $b)
	{
		$a = $this->normalize($a);
		$b = $this->normalize($b);
		return $a === $b;
	}
}
