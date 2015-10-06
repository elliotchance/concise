<?php

namespace Concise\Console\ResultPrinter;

class CIResultPrinter extends DefaultResultPrinter
{
    protected $lastPercentage = -1;

    public function update()
    {
        var_dump($this->getTestCount());
        $percentage = $this->counter->getPercentage($this->getTestCount());
        if ($percentage > $this->lastPercentage) {
            $this->write($this->getAssertionString());
            $this->lastPercentage = $percentage;
        }
    }

//    public function appendTextAbove($text)
//    {
//        parent::appendTextAbove("\n$text");
//    }
}
