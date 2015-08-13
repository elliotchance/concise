<?php

namespace Concise\Modules;

use Concise\Matcher\AbstractMatcher;

class BooleanModule extends AbstractMatcher
{
    /**
     * Always fail.
     *
     * @syntax false
     * @return bool
     */
    public function false()
    {
        return false;
    }

    /**
     * Assert value is false.
     *
     * @syntax ? is false
     * @return bool
     */
    public function isFalse()
    {
        return $this->data[0] === false;
    }

    /**
     * Assert a value is a false-like value.
     *
     * @syntax ? is falsy
     * @return bool
     */
    public function isFalsy()
    {
        return !$this->isTruthy();
    }

    /**
     * Assert a value is true.
     *
     * @syntax ? is true
     * @return bool
     */
    public function isTrue()
    {
        return $this->data[0] === true;
    }

    /**
     * Assert a value is a non false-like value.
     *
     * @syntax ? is truthy
     * @return bool
     */
    public function isTruthy()
    {
        return (bool)$this->data[0];
    }

    /**
     * Always pass.
     *
     * @syntax true
     * @return bool
     */
    public function true()
    {
        return true;
    }
}
