<?php

namespace Concise\Syntax\Token;

use Concise\Syntax\Token;

class Attribute extends Token
{
	public function getAcceptedTypes()
	{
		return array('int');
	}
}
