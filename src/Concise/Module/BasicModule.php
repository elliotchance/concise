<?php

namespace Concise\Module;

class BasicModule extends AbstractModule
{
    public function getName()
    {
        return "Basic";
    }

    /**
     * Assert values with no regard to exact data types.
     *
     * @syntax ? equals ?
     */
    public function equal()
    {
        $this->failIf($this->data[0] != $this->data[1]);
    }

    /**
     * Assert two values match data type and value.
     *
     * @syntax ? exactly equals ?
     * @syntax ? is the same as ?
     */
    public function exactlyEqual()
    {
        $this->failIf($this->data[0] !== $this->data[1]);
    }

    /**
     * Assert two value do not match with no regard to type.
     *
     * @syntax ? does not equal ?
     */
    public function notEqual()
    {
        $this->failIf($this->data[0] == $this->data[1]);
    }

    /**
     * Assert two values are of exactly the same type and value.
     *
     * @syntax ? does not exactly equal ?
     * @syntax ? is not the same as ?
     */
    public function notExactlyEqual()
    {
        $this->failIf($this->data[0] === $this->data[1]);
    }
}
