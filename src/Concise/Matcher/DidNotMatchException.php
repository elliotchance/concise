<?php

namespace Concise\Matcher;

class DidNotMatchException extends \Exception
{
	public function getTags()
	{
		return array(Tag::EXCEPTIONS);
	}
}
