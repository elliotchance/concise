<?php

namespace Concise\Console\ResultPrinter\Utilities;

use DomainException;
use Concise\Validation\ArgumentChecker;

class ProgressCounter
{
    /**
     * Total value
     * @var integer
     */
    protected $total;

    /**
     * @var boolean
     */
    protected $showPercentage;

    protected function atLeastZero($value, $name)
    {
        if ($value < 0) {
            throw new DomainException("$name must be at least zero.");
        }
    }

    /**
     * @param integer $total
     * @param boolean $showPercentage
     */
    public function __construct($total, $showPercentage = false)
    {
        $this->atLeastZero($total, 'Total');
        $this->total = $total;
        $this->showPercentage = $showPercentage;
    }

    public function render($value = 0)
    {
        ArgumentChecker::check($value, 'integer');

        $this->atLeastZero($value, 'Value');
        $r = $value . ' / ' . max($value, $this->total);
        if ($this->showPercentage) {
            $percentage = (0 === $this->total) ? 0 : floor($value / $this->total * 100);
            $r .= sprintf(' (%3s%%)', min(100, $percentage));
        }

        return $r;
    }
}
