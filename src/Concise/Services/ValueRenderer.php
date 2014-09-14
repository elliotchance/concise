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
        return is_null($value) || is_array($value) || is_object($value) || is_bool($value);
    }

    protected function colorize($value)
    {
        $c = new Color();
        if (!$this->theme) {
            return (string) $value;
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

    protected function jsonEncode($value)
    {
        if (is_object($value)) {
            $r = '{';
            foreach ((array) $value as $k => $v) {
                $r .= $this->colorize("\"$k\"") . ':' . $this->render($v);
            }

            return "$r}";
        }
        if (is_array($value)) {
            $r = '';
            foreach ($value as $k => $v) {
                if ($r) {
                    $r .= ',';
                }
                $r .= $this->render($v);
            }

            return "[$r]";
        }

        return json_encode($value);
    }

    /**
	 * @param  mixed $value
	 * @return string
	 */
    public function render($value)
    {
        $c = new Color();
        if ($value instanceof Closure) {
            return ($this->theme ? $c('function')->{$this->theme['value.closure']} : 'function');
        }
        if (is_object($value)) {
            return get_class($value) . ':' . $this->jsonEncode($value);
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
