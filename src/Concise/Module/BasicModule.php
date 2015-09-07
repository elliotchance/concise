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
     * @syntax ? is equal to ?
     * @return bool
     */
    public function equal()
    {
        $this->failIf($this->data[0] != $this->data[1]);
    }

    /**
     * Assert two values match data type and value.
     *
     * @syntax ? is exactly equal to ?
     * @syntax ? exactly equals ?
     * @syntax ? is the same as ?
     * @return bool
     */
    public function exactlyEqual()
    {
        $this->failIf($this->data[0] !== $this->data[1]);
    }

    /**
     * Assert two value do not match with no regard to type.
     *
     * @syntax ? does not equal ?
     * @syntax ? is not equal to ?
     * @syntax ? not equals ?
     * @return bool
     */
    public function notEqual()
    {
        $this->failIf($this->data[0] == $this->data[1]);
    }

    /**
     * Assert two values are of exactly the same type and value.
     *
     * @syntax ? is not the same as ?
     * @syntax ? does not exactly equal ?
     * @syntax ? is not exactly equal to ?
     * @return bool
     */
    public function notExactlyEqual()
    {
        $this->failIf($this->data[0] === $this->data[1]);
    }
}
