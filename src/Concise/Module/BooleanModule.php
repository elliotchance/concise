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
     * @return bool
     */
    public function isFalse()
    {
        $this->failIf($this->data[0] !== false);
    }

    /**
     * Assert a value is a false-like value.
     *
     * @syntax ? is falsy
     * @return bool
     */
    public function isFalsy()
    {
        $this->failIf($this->data[0] != false);
    }

    /**
     * Assert a value is true.
     *
     * @syntax ? is true
     * @return bool
     */
    public function isTrue()
    {
        $this->failIf($this->data[0] !== true);
    }

    /**
     * Assert a value is a non false-like value.
     *
     * @syntax ? is truthy
     * @return bool
     */
    public function isTruthy()
    {
        $this->failIf($this->data[0] != true);
    }
}
