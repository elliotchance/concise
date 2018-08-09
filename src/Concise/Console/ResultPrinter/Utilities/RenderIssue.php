<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Colors\Color;
use Concise\Console\Theme\DefaultTheme;
use Concise\Core\ArgumentChecker;
use Exception;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\Test;

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
    protected $colors;

    public function __construct(TraceSimplifier $traceSimplifier = null)
    {
        if (!$traceSimplifier) {
            $traceSimplifier = new TraceSimplifier();
        }
        $this->traceSimplifier = $traceSimplifier;
        $this->theme = new DefaultTheme();
        $this->colors = $this->theme->getTheme();
    }

    /**
     * @param string $prefix
     * @param string $lines
     * @return string
     */
    protected function prefixLines($prefix, $lines)
    {
        $lines = str_replace("\r", "", $lines);
        return $prefix . str_replace("\n", "\n$prefix", $lines);
    }

    /**
     * @param Exception $e
     * @return string
     */
    protected function getPHPUnitDiff(Exception $e)
    {
        if ($e instanceof ExpectationFailedException) {
            $comparisonFailure = $e->getComparisonFailure();
            if ($comparisonFailure) {
                return $comparisonFailure->getDiff();
            }
        }

        return '';
    }

    /**
     * @param integer                $status
     * @param integer                $issueNumber
     * @param Test $test
     * @return string
     */
    protected function getHeading(
        $status,
        $issueNumber,
        Test $test
    ) {
        $c = new Color();
        $color = $this->colors[$status];

        $message = get_class($test);
        if ($test instanceof TestCase) {
            $message .= '::' . $test->getName();
        }
        return "$issueNumber. " . $c($message)->$color . "\n\n";
    }

    /**
     * @param integer                $status
     * @param integer                $issueNumber
     * @param Test $test
     * @param Exception              $e
     * @return string
     */
    public function render(
        $status,
        $issueNumber,
        Test $test,
        Exception $e
    ) {
        ArgumentChecker::check($issueNumber, 'integer');

        $c = new Color();
        $top = $this->getHeading($status, $issueNumber, $test);
        $message = $e->getMessage() . "\n";
        $message .= $this->getPHPUnitDiff($e);
        $message .= "\n" . $this->prefixLines(
                "\033[90m",
                $this->traceSimplifier->render($e->getTrace())
            ) . "\033[0m";
        $pad = str_repeat(' ', strlen($issueNumber));

        return $top . $this->prefixLines(
            $c("  ")->highlight($this->colors[$status]) . $pad,
            rtrim($message)
        );
    }
}
