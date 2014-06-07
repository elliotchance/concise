<?php

namespace Concise\Matcher;

use \Concise\Services\ToStringConverter;

class MatchesRegularExpression extends AbstractMatcher
{
	public function supportedSyntaxes()
	{
		return array(
			'? matches regular expression ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		$converter = new ToStringConverter();
		$subject = $converter->convertToString($data[0]);
		$pattern = $converter->convertToString($data[1]);
		return preg_match('/' . $pattern . '/', $subject) === 1;
	}
}
