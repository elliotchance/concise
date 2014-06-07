<?php

namespace Concise\Matcher;

use \Concise\Services\ToStringConverter;

class DoesNotMatchRegularExpression extends MatchesRegularExpression
{
	public function supportedSyntaxes()
	{
		return array(
			'? does not match regular expression ?',
			'? doesnt match regular expression ?',
			'? does not match regex ?',
			'? doesnt match regex ?',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match('? matches regular expression ?', $data);
	}
}
