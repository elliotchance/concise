<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;

class NumberModule extends AbstractModule
{
    public function getName()
    {
        return "Numbers";
    }

    /**
     * A number must be between two values (inclusive), returns value.
     *
     * @return mixed
     * @throws DidNotMatchException
     * @nested
     * @syntax ?:number is between ?:number and ?:number
     * @syntax ?:number between ?:number and ?:number
     */
    public function between()
    {
        if ($this->data[0] < $this->data[1] ||
            $this->data[0] > $this->data[2]
        ) {
            throw new DidNotMatchException();
        }

        return $this->data[0];
    }

    /**
     * Assert two values are not close to each other.
     *
     * @return bool
     * @syntax ?:number is not within ?:number of ?:number
     */
    public function doesNotEqualWithin()
    {
        return !$this->equalsWithin();
    }

    /**
     * Assert two values are close to each other.
     *
     * @return bool
     * @syntax ?:number is within ?:number of ?:number
     */
    public function equalsWithin()
    {
        return abs($this->data[2] - $this->data[0]) <= $this->data[1];
    }

    /**
     * A number is greater than another number.
     *
     * @return bool
     * @syntax ?:number is greater than ?:number
     * @syntax ?:number greater than ?:number
     * @syntax ?:number gt ?:number
     */
    public function isGreaterThan()
    {
        return $this->data[0] > $this->data[1];
    }

    /**
     * A number is greater than or equal to another number.
     *
     * @return bool
     * @syntax ?:number is greater than or equal to ?:number
     * @syntax ?:number greater than or equal ?:number
     * @syntax ?:number gte ?:number
     */
    public function isGreaterThanEqual()
    {
        return $this->data[0] >= $this->data[1];
    }

    /**
     * A number is less than another number.
     *
     * @return bool
     * @syntax ?:number is less than ?:number
     * @syntax ?:number less than ?:number
     * @syntax ?:number lt ?:number
     */
    public function isLessThan()
    {
        return $this->data[0] < $this->data[1];
    }

    /**
     * A number is less than or equal to another number.
     *
     * @return bool
     * @syntax ?:number is less than or equal to ?:number
     * @syntax ?:number less than or equal ?:number
     * @synatx ?:number lte ?:number
     */
    public function isLessThanEqual()
    {
        return $this->data[0] <= $this->data[1];
    }

    /**
     * A number must not be between two values (inclusive).
     *
     * @syntax ?:number is not between ?:number and ?:number
     * @syntax ?:number not between ?:number and ?:number
     * @return bool
     */
    public function notBetween()
    {
        return
            $this->data[0] < $this->data[1] ||
            $this->data[0] > $this->data[2];
    }
}
