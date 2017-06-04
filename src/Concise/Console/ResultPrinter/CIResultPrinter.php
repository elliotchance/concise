<?php

namespace Concise\Console\ResultPrinter;

class CIResultPrinter extends DefaultResultPrinter
{
    protected $lastPercentage = -1;

    public function update()
    {
        $percentage = $this->counter->getPercentage($this->getTestCount());
        if ($percentage > $this->lastPercentage) {
            $this->write($this->getAssertionString());
            $this->lastPercentage = $percentage;
        }
    }

    public function appendTextAbove($text)
    {
        parent::appendTextAbove("\n$text");
    }

    protected function restoreCursor()
    {
        // Normally this would use an ANSI escape code to move the cursor in the
        // terminal back to where it was, but under CI mode we don't have a
        // cursor or want to output ANSI escape codes.
    }

    protected function processTextBeforWriting($text)
    {
        // Normally this method replaces the newlines with some extra ANSI
        // codes. We don't want to do that in CI mode.
        return $text;
    }

    /**
     * @return string
     */
    protected function afterWriteTextAbove()
    {
        return "\n\n";
    }
}
