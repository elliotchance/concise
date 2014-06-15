<?php

namespace Concise\Matcher;

use \Concise\Services\ToStringConverter;

class DoesNotMatchRegularExpression extends MatchesRegularExpression
{
	public function supportedSyntaxes()
	{
		return array(
			'? does not match regular expression ?:regex',
			'? doesnt match regular expression ?:regex',
			'? does not match regex ?:regex',
			'? doesnt match regex ?:regex',
		);
	}

	public function match($syntax, array $data = array())
	{
		return !parent::match('? matches regular expression ?', $data);
	}
}
