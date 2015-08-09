<?php

namespace Concise\Modules\DateAndTime;

class DateIsBefore extends AbstractDateComparison
{
    public function match($syntax, array $data = array())
    {
        return parent::compare($data, 1);
    }
}
