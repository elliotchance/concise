<?php

namespace Concise\Core;

use Closure;
use Concise\Console\ResultPrinter\Utilities\ColorText;
use Concise\Console\Theme\ThemeInterface;

class ValueRenderer
{
    /**
     * @var ThemeInterface
     */
    protected $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    /**
     * @param $value
     * @return string
     */
    protected function colorizeLines($value)
    {
        $c = new ColorText();
        $lines = explode("\n", $value);
        $string = array();
        foreach ($lines as $line) {
            $string[] = $c->color($line, $this->theme->getValueStringColor());
        }

        return implode("\n", $string);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function colorize($value)
    {
        $c = new ColorText();

        if (!$this->theme) {
            return (is_null($value) || is_bool($value)) ? json_encode($value)
                : (string)$value;
        }
        if (is_null($value)) {
            return $c->color('null', $this->theme->getValueNullColor());
        }
        if (is_bool($value)) {
            return $c->color(
                json_encode($value),
                $this->theme->getValueBooleanColor()
            );
        }
        if (is_int($value)) {
            return $c->color($value, $this->theme->getValueIntegerColor());
        }
        if (is_float($value)) {
            return $c->color($value, $this->theme->getValueFloatColor());
        }
        if (is_resource($value)) {
            return $c->color(
                (string)$value,
                $this->theme->getValueStringColor()
            );
        }

        return $this->colorizeLines($value);
    }

    /**
     * @param array   $values
     * @param integer $depth
     * @param Closure $callback
     * @return string
     */
    protected function jsonEncodeCallback(
        array $values,
        $depth,
        Closure $callback
    ) {
        $r = '';
        foreach ($values as $k => $v) {
            if ($r) {
                $r .= ",\n";
            }
            $r .= $this->createIndent($depth) . $callback($k, $v);
        }

        return $r;
    }

    /**
     * @param integer $depth
     * @return string
     */
    protected function createIndent($depth)
    {
        return str_repeat('  ', $depth);
    }

    /**
     * @param mixed   $value
     * @param integer $depth
     * @return string
     */
    protected function jsonEncode($value, $depth)
    {
        $self = $this;
        if (is_object($value) ||
            (is_array($value) && $this->isAssociativeArray($value))
        ) {
            $r = $this->jsonEncodeCallback(
                (array)$value,
                $depth + 1,
                function ($k, $v) use ($depth, $self) {
                    return $self->colorize("\"$k\"") . ':' .
                    $self->render($v, false, $depth + 1);
                }
            );

            return "{\n" . $r . "\n" . $this->createIndent($depth) . "}";
        }

        /** @noinspection PhpUnusedParameterInspection */
        $r = $this->jsonEncodeCallback(
            (array)$value,
            $depth + 1,
            function ($k, $v) use ($depth, $self) {
                return $self->render($v, false, $depth + 1);
            }
        );

        return "[\n$r\n" . $this->createIndent($depth) . "]";
    }

    /**
     * @param array $a
     * @return bool
     */
    protected function isAssociativeArray(array $a)
    {
        return array_keys($a) !== range(0, count($a) - 1);
    }

    /**
     * @param string $value
     * @return string
     */
    protected function renderString($value)
    {
        if ($value === TestCase::ANYTHING) {
            return '<ANYTHING>';
        }

        return $this->colorize('"' . $value . '"');
    }

    /**
     * @return string
     */
    protected function renderClosure()
    {
        $c = new ColorText();
        return $this->theme
            ? $c->color('function', $this->theme->getValueClosureColor())
            : 'function';
    }

    /**
     * @param boolean $showTypeHint
     * @param object  $value
     * @param integer $depth
     * @return string
     */
    protected function renderObject($showTypeHint, $value, $depth)
    {
        return ($showTypeHint ? get_class($value) . ':' : '') .
        $this->jsonEncode($value, $depth);
    }

    /**
     * @param  mixed $value
     * @param bool   $showTypeHint
     * @param int    $depth
     * @return string
     */
    public function render($value, $showTypeHint = true, $depth = 0)
    {
        if ($depth >= $this->getMaximumDepth()) {
            return "...";
        }
        if ($value instanceof Closure) {
            return $this->renderClosure();
        }
        if (is_object($value)) {
            return $this->renderObject($showTypeHint, $value, $depth);
        }
        if (is_array($value)) {
            return $this->jsonEncode($value, $depth);
        }
        if (is_string($value)) {
            return $this->renderString($value);
        }

        return $this->colorize($value);
    }

    public function getMaximumDepth()
    {
        return 10;
    }

    public function renderAll(array $items)
    {
        return implode(', ', array_map(array($this, 'render'), $items));
    }
}
