<?php

namespace Concise\Services;

class Comparer
{
	protected $convertToString;

	public function setConvertToString(\Concise\Services\ConvertToString $convertToString)
	{
		$this->convertToString = $convertToString;
	}

	protected function normalize($value)
	{
		if(!is_bool($value) && !is_null($value)) {
			$value = $this->convertToString->convertToString($value);
		}
		return $value;
	}

	public function compare($a, $b)
	{
		$a = $this->normalize($a);
		$b = $this->normalize($b);
		return $a == $b;
	}
}
