<?php

namespace Concise\Services;

class MatcherSyntaxAndDescription
{
	public function process(array $syntaxes)
	{
		$r = array();
		foreach($syntaxes as $v) {
			$r[$v] = null;
		}
		return $r;
	}
}
