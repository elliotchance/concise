<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Validation\ArgumentChecker;
use DomainException;

class ProgressCounter
{
    /**
     * Total value
     *
     * @var integer
     */
    protected $total;

    /**
     * @var boolean
     */
    protected $showPercentage;

    /**
     * @param integer $value
     * @param string  $name
     */
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
        ArgumentChecker::check($total, 'integer', 1);
        ArgumentChecker::check($showPercentage, 'boolean', 2);

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
            $r .= sprintf(' (%3s%%)', min(100, $this->getPercentage($value)));
        }

        return $r;
    }

    /**
     * @param integer $value
     * @return int
     */
    public function getPercentage($value)
    {
        return (0 === $this->total)
            ? 0
            : (int)floor($value / $this->total * 100);
    }
}
