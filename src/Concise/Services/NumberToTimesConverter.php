<?php

namespace Concise\Services;

use \Concise\TestCase;

class NumberToTimesConverter
{
	public function convert($number)
	{
		if($number === 0) {
			return 'never';
		}
		return 'once';
	}
}
