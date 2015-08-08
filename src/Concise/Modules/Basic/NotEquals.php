<?php

namespace Concise\Modules\Basic;

use Concise\Matcher\Equals;

class NotEquals extends Equals
{
    const DESCRIPTION = '';

    public function supportedSyntaxes()
    {
        return array(
            '' => self::DESCRIPTION,
            '' => self::DESCRIPTION,
            '' => self::DESCRIPTION,
        );
    }

    public function match($syntax, array $data = array())
    {
        return !parent::match($syntax, $data);
    }
}
