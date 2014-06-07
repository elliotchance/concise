<?php

namespace Concise\Services;

class MatcherSyntaxAndDescription
{
	protected function isAssociative(array $arr)
	{
		return array_keys($arr) !== range(0, count($arr) - 1);
	}

	public function process(array $syntaxes)
	{
		if($this->isAssociative($syntaxes)) {
			return $syntaxes;
		}
		$r = array();
		foreach($syntaxes as $v) {
			$r[$v] = null;
		}
		return $r;
	}
}
