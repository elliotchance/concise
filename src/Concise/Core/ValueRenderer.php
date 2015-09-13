<?php

namespace Concise\Core;

use Closure;
use Colors\Color;
use Concise\Console\Theme\DefaultTheme;
use Concise\TestCase;

class ValueRenderer
{
    /**
     * @var array
     */
    protected $theme;

    /**
     * @param $value
     * @return string
     */
    protected function colorizeLines($value)
    {
        $c = new Color();
        $lines = explode("\n", $value);
        $string = array();
        foreach ($lines as $line) {
            $string[] = (string)$c($line)->{$this->theme['value.string']};
        }

        return implode("\n", $string);
    }

    /**
     * @param mixed $value
     * @return string
     */
    public function colorize($value)
    {
        $c = new Color();
        if (!$this->theme) {
            return (is_null($value) || is_bool($value)) ? json_encode($value)
                : (string)$value;
        }
        if (is_null($value)) {
            return (string)$c('null')->{$this->theme['value.null']};
        }
        if (is_bool($value)) {
            return (string)$c(
                json_encode($value)
            )->{$this->theme['value.boolean']};
        }
        if (is_int($value)) {
            return (string)$c($value)->{$this->theme['value.integer']};
        }
        if (is_float($value)) {
            return (string)$c($value)->{$this->theme['value.float']};
        }
        if (is_resource($value)) {
            return (string)$c((string)$value)->{$this->theme['value.string']};
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
        $c = new Color();
        return ($this->theme ? $c('function')->{$this->theme['value.closure']}
            : 'function');
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
            return $this->renderClosure($value);
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

    public function setTheme(DefaultTheme $theme)
    {
        $this->theme = $theme->getTheme();
    }
}
