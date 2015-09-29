<?php

namespace Concise\Module;

class BooleanModule extends AbstractModule
{
    public function getName()
    {
        return "Booleans";
    }

    /**
     * Assert value is false.
     *
     * @syntax ? is false
     */
    public function isFalse()
    {
        $this->failIf($this->data[0] !== false);
    }

    /**
     * Assert a value is a false-like value.
     *
     * @syntax ? is falsy
     */
    public function isFalsy()
    {
        $this->failIf($this->data[0] != false);
    }

    /**
     * Assert a value is true.
     *
     * @syntax ? is true
     */
    public function isTrue()
    {
        $this->failIf($this->data[0] !== true);
    }

    /**
     * Assert a value is a non false-like value.
     *
     * @syntax ? is truthy
     */
    public function isTruthy()
    {
        $this->failIf($this->data[0] != true);
    }
}
