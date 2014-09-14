<?php

namespace Concise\Services;

use Closure;
use Concise\Console\Theme\DefaultTheme;
use Colors\Color;

class ValueRenderer
{
    protected $theme;

    protected function shouldBeJsonEncoded($value)
    {
        return is_array($value) || is_object($value) || is_bool($value);
    }

    protected function colorize($value)
    {
        $c = new Color();
        if (!$this->theme) {
            return (is_null($value) || is_bool($value)) ? json_encode($value) : (string) $value;
        }
        if (is_null($value)) {
            return (string) $c('null')->{$this->theme['value.null']};
        }
        if (is_bool($value)) {
            return (string) $c(json_encode($value))->{$this->theme['value.boolean']};
        }
        if (is_int($value)) {
            return (string) $c($value)->{$this->theme['value.integer']};
        }
        if (is_float($value)) {
            return (string) $c($value)->{$this->theme['value.float']};
        }
        if (is_string($value)) {
            return (string) $c($value)->{$this->theme['value.string']};
        }

        return (string) $value;
    }

    protected function jsonEncodeCallback(array $values, Closure $callback)
    {
        $r = '';
        foreach ($values as $k => $v) {
            if ($r) {
                $r .= ',';
            }
            $r .= $callback($k, $v);
        }

        return $r;
    }

    protected function jsonEncode($value)
    {
        if (is_object($value) || (is_array($value) && $this->isAssociativeArray($value))) {
            $r = $this->jsonEncodeCallback((array) $value, function ($k, $v) {
                return $this->colorize("\"$k\"") . ':' . $this->render($v, false);
            });

            return "{" . $r . "}";
        }
        if (is_array($value)) {
            $r = $this->jsonEncodeCallback((array) $value, function ($k, $v) {
                return $this->render($v, false);
            });

            return "[$r]";
        }

        return json_encode($value);
    }

    protected function isAssociativeArray(array $a)
    {
        return array_keys($a) !== range(0, count($a) - 1);
    }

    /**
	 * @param  mixed $value
	 * @return string
	 */
    public function render($value, $showTypeHint = true)
    {
        $c = new Color();
        if (is_null($value) || is_bool($value)) {
            return $this->colorize($value);
        }
        if ($value instanceof Closure) {
            return ($this->theme ? $c('function')->{$this->theme['value.closure']} : 'function');
        }
        if (is_object($value)) {
            return ($showTypeHint ? get_class($value) . ':' : '') . $this->jsonEncode($value);
        }
        if (is_array($value)) {
            return $this->jsonEncode($value);
        }
        if ($this->shouldBeJsonEncoded($value)) {
            return json_encode($value);
        }
        if (is_string($value)) {
            return $this->colorize('"' . $value . '"');
        }

        return $this->colorize($value);
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
