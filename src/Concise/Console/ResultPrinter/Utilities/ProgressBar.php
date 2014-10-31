<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;
use Concise\Validation\ArgumentChecker;

class ProgressBar
{
    /**
     * The sum of all the parts.
     * @var integer
     */
    protected $total;

    /**
     * The width (in column/characters of the progress bar).
     * @var integer
     */
    protected $size;

    /**
     * The individual [color => value] that make up the progress bar.
     * @var integer[]
     */
    protected $parts;

    protected function valueToBars($value)
    {
        if ($value <= 0 || $this->total == 0) {
            return 0;
        }

        return ceil($value / $this->total * $this->size);
    }

    protected function calculateTotal(array $parts)
    {
        $this->total = array_sum($parts);
    }

    protected function colorSpaces($length, $colorName)
    {
        $c = new Color();

        return (string) $c(str_repeat(' ', $length))->highlight($colorName);
    }

    protected function fillToSize($currentProgressBar)
    {
        reset($this->parts);
        $fill = $this->size - substr_count($currentProgressBar, ' ');
        if ($fill < 0) {
            $currentProgressBar = preg_replace('/\s\s/', ' ', $currentProgressBar, -$fill);
        }

        return $currentProgressBar;
    }

    /**
     * Render the progress bar.
     * @param  integer $size  The width (in column/characters of the progress bar).
     * @param  array   $parts The individual [color => value] that make up the progress bar.
     * @return string
     */
    public function render($size, array $parts)
    {
        ArgumentChecker::check($size, 'integer');

        $this->calculateTotal($parts);
        $this->size = $size;
        $this->parts = $parts;

        $r = '';

        foreach ($parts as $color => $x) {
            $bars = $this->valueToBars($x);
            $r .= $this->colorSpaces($bars, $color);
        }

        $r = $this->fillToSize($r);

        return $r;
    }
}
