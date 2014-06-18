<?php

namespace Concise\Matcher;

use \Concise\Services\ToStringConverter;

class DoesNotMatchRegularExpression extends MatchesRegularExpression
{
	const DESCRIPTION = 'Check if a string does not match a regular expression.';

	public function supportedSyntaxes()
	{
		return array(
			'? does not match regular expression ?:regex' => self::DESCRIPTION,
			'? doesnt match regular expression ?:regex' => self::DESCRIPTION,
			'? does not match regex ?:regex' => self::DESCRIPTION,
			'? doesnt match regex ?:regex' => self::DESCRIPTION,
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match('? matches regular expression ?:regex', $data);
	}
}
