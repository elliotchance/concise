<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Exception;
use Colors\Color;
use Concise\Console\Theme\DefaultTheme;
use PHPUnit_Framework_Test;
use PHPUnit_Framework_ExpectationFailedException;
use Concise\Validation\ArgumentChecker;

class RenderIssue
{
    /**
     * @var TraceSimplifier
     */
    protected $traceSimplifier;

    /**
     * @var DefaultTheme
     */
    protected $theme;

    /**
     * @var array
     */
    protected $colours;

    public function __construct(TraceSimplifier $traceSimplifier = null)
    {
        if (!$traceSimplifier) {
            $traceSimplifier = new TraceSimplifier();
        }
        $this->traceSimplifier = $traceSimplifier;
        $this->theme = new DefaultTheme();
        $this->colors = $this->theme->getTheme();
    }

    protected function prefixLines($prefix, $lines)
    {
        return $prefix . str_replace("\n", "\n$prefix", $lines);
    }

    protected function getPHPUnitDiff(Exception $e)
    {
        if ($e instanceof PHPUnit_Framework_ExpectationFailedException) {
            $comparisonFailure = $e->getComparisonFailure();
            if ($comparisonFailure) {
                return $comparisonFailure->getDiff();
            }
        }

        return '';
    }

    protected function getHeading($status, $issueNumber, PHPUnit_Framework_Test $test)
    {
        $c = new Color();
        $color = $this->colors[$status];

        return "$issueNumber. " . $c(get_class($test) . '::' . $test->getName())->$color . "\n\n";
    }

    public function render($status, $issueNumber, PHPUnit_Framework_Test $test, Exception $e)
    {
        ArgumentChecker::check($issueNumber, 'integer');

        $c = new Color();
        $top = $this->getHeading($status, $issueNumber, $test);
        $message = $e->getMessage() . "\n";
        $message .= $this->getPHPUnitDiff($e);
        $message .= "\n" . $this->prefixLines("\033[90m", $this->traceSimplifier->render($e->getTrace())) . "\033[0m";
        $pad = str_repeat(' ', strlen($issueNumber));

        return $top . $this->prefixLines($c("  ")->highlight($this->colors[$status]) . $pad, rtrim($message));
    }
}
