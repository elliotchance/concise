<?php

namespace Concise\Console\ResultPrinter;

class CIResultPrinter extends DefaultResultPrinter
{
    protected $lastPercentage = -1;

    public function update()
    {
        $percentage = $this->counter->getPercentage($this->getTestCount());
        var_dump($this->getTestCount(), $percentage, $this->lastPercentage);
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
