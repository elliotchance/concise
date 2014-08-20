<?php

namespace Concise\Services;

class ValueRenderer
{
    protected function shouldBeJsonEncoded($value)
    {
        return is_null($value) || is_array($value) || is_object($value) || is_bool($value);
    }

    /**
	 * @param  mixed $value
	 * @return string
	 */
    public function render($value)
    {
        if (is_callable($value)) {
            return 'function';
        }
        if (is_object($value)) {
            return get_class($value) . ':' . json_encode($value);
        }
        if ($this->shouldBeJsonEncoded($value)) {
            return json_encode($value);
        }
        if (is_string($value)) {
            return '"' . $value . '"';
        }

        return (string) $value;
    }

    public function renderAll(array $items)
    {
        return implode(', ', array_map(array($this, 'render'), $items));
    }
}
