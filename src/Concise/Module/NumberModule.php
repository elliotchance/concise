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
     * @syntax ?:number is between ?:number and ?:number
     */
    public function between()
    {
        $this->failIf($this->data[0] < $this->data[1]);
        $this->failIf($this->data[0] > $this->data[2]);

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
        $this->failIf($this->numberIsWithin());
    }

    /**
     * Assert two values are close to each other.
     *
     * @return bool
     * @syntax ?:number is within ?:number of ?:number
     */
    public function equalsWithin()
    {
        $this->failIf(!$this->numberIsWithin());
    }

    /**
     * A number is greater than another number.
     *
     * @syntax ?:number is greater than ?:number
     */
    public function isGreaterThan()
    {
        $this->failIf($this->data[0] <= $this->data[1]);
    }

    /**
     * A number is greater than or equal to another number.
     *
     * @return bool
     * @syntax ?:number is greater than or equal to ?:number
     */
    public function isGreaterThanEqual()
    {
        $this->failIf($this->data[0] < $this->data[1]);
    }

    /**
     * A number is less than another number.
     *
     * @return bool
     * @syntax ?:number is less than ?:number
     */
    public function isLessThan()
    {
        $this->failIf($this->data[0] >= $this->data[1]);
    }

    /**
     * A number is less than or equal to another number.
     *
     * @return bool
     * @syntax ?:number is less than or equal to ?:number
     */
    public function isLessThanEqual()
    {
        $this->failIf($this->data[0] > $this->data[1]);
    }

    /**
     * A number must not be between two values (inclusive).
     *
     * @syntax ?:number is not between ?:number and ?:number
     * @return bool
     */
    public function notBetween()
    {
        $this->failIf(
            $this->data[0] >= $this->data[1] &&
            $this->data[0] <= $this->data[2]
        );
    }

    /**
     * @return bool
     */
    protected function numberIsWithin()
    {
        return abs($this->data[2] - $this->data[0]) <= $this->data[1];
    }
}
