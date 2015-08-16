<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcher;

class TypeModule extends AbstractMatcher
{
    /**
     * Assert a value is true or false.
     *
     * @syntax ? is a boolean
     * @syntax ? is a bool
     * @return bool
     */
    public function isABoolean()
    {
        return is_bool($this->data[0]);
    }

    /**
     * Assert a value is an array.
     *
     * @return bool
     * @syntax ? is an array
     */
    public function isAnArray()
    {
        return is_array($this->data[0]);
    }

    /**
     * Assert value is an integer type.
     *
     * @return bool
     * @syntax ? is an int
     * @syntax ? is an integer
     */
    public function isAnInteger()
    {
        return is_int($this->data[0]);
    }

    /**
     * Assert value is an object.
     *
     * @return bool
     * @syntax ? is an object
     */
    public function isAnObject()
    {
        return is_object($this->data[0]);
    }

    /**
     * Assert that a value is an integer or floating-point.
     *
     * @return bool
     * @syntax ? is a number
     */
    public function isANumber()
    {
        return is_int($this->data[0]) || is_float($this->data[0]);
    }

    /**
     * Assert value is a string.
     *
     * @return bool
     * @syntax ? is a string
     */
    public function isAString()
    {
        return is_string($this->data[0]);
    }

    /**
     * Assert an objects class or subclass.
     *
     * @return bool
     * @syntax ?:object,class is an instance of ?:class
     * @syntax ?:object,class is instance of ?:class
     * @syntax ?:object,class instance of ?:class
     */
    public function isInstanceOf()
    {
        $interfaces = class_implements($this->data[0]);

        if (is_string($this->data[0])) {
            return true;
        }
        return (get_class($this->data[0]) === $this->data[1]) ||
        is_subclass_of($this->data[0], $this->data[1]) ||
        array_key_exists($this->data[1], $interfaces);
    }

    /**
     * Assert a value is not true or false.
     *
     * @return bool
     * @syntax ? is not a boolean
     * @syntax ? is not a bool
     */
    public function isNotABoolean()
    {
        return !$this->isABoolean();
    }

    /**
     * Assert a value is not an array.
     *
     * @return bool
     * @syntax ? is not an array
     */
    public function isNotAnArray()
    {
        return !$this->isAnArray();
    }

    /**
     * Assert a value is not an integer type.
     *
     * @return bool
     * @syntax ? is not an int
     * @syntax ? is not an integer
     */
    public function isNotAnInteger()
    {
        return !$this->isAnInteger();
    }

    /**
     * Assert a value is not an object.
     *
     * @return bool
     * @syntax ? is not an object
     */
    public function isNotAnObject()
    {
        return !$this->isAnObject();
    }

    /**
     * Assert that a value is not an integer or floating-point.
     *
     * @return bool
     * @syntax ? is not a number
     */
    public function isNotANumber()
    {
        return !$this->isANumber();
    }

    /**
     * Assert a value is not a string.
     *
     * @return bool
     * @syntax ? is not a string
     */
    public function isNotAString()
    {
        return !$this->isAString();
    }

    /**
     * Assert than an object is not a class or subclass.
     *
     * @return bool
     * @syntax ?:object,class is not an instance of ?:class
     * @syntax ?:object,class is not instance of ?:class
     * @syntax ?:object,class not instance of ?:class
     */
    public function isNotAnInstanceOf()
    {
        return !$this->isInstanceOf();
    }

    /**
     * Assert a value is not null.
     *
     * @return bool
     * @syntax ? is not null
     */
    public function isNotNull()
    {
        return !$this->isNull();
    }

    /**
     * Assert value is not a number or string that represents a number.
     *
     * @return bool
     * @syntax ? is not numeric
     */
    public function isNotNumeric()
    {
        return !$this->isNumeric();
    }

    /**
     * Assert a value is null.
     *
     * @return bool
     * @syntax ? is null
     */
    public function isNull()
    {
        return is_null($this->data[0]);
    }

    /**
     * Assert value is a number or string that represents a number.
     *
     * @return bool
     * @syntax ? is numeric
     */
    public function isNumeric()
    {
        return is_numeric($this->data[0]);
    }
}
