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
		if($number === 2) {
			return 'twice';
		}
		return 'once';
	}
}
