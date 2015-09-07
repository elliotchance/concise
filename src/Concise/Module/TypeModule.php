<?php

namespace Concise\Module;

class TypeModule extends AbstractModule
{
    public function getName()
    {
        return "Types";
    }

    /**
     * Assert a value is true or false.
     *
     * @syntax ? is a boolean
     * @syntax ? is a bool
     * @return bool
     */
    public function isABoolean()
    {
        $this->failIf(!is_bool($this->data[0]));
    }

    /**
     * Assert a value is an array.
     *
     * @return bool
     * @syntax ? is an array
     */
    public function isAnArray()
    {
        $this->failIf(!is_array($this->data[0]));
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
        $this->failIf(!is_int($this->data[0]));
    }

    /**
     * Assert value is an object.
     *
     * @return bool
     * @syntax ? is an object
     */
    public function isAnObject()
    {
        $this->failIf(!is_object($this->data[0]));
    }

    /**
     * Assert that a value is an integer or floating-point.
     *
     * @return bool
     * @syntax ? is a number
     */
    public function isANumber()
    {
        $this->failIf(!is_int($this->data[0]) && !is_float($this->data[0]));
    }

    /**
     * Assert value is a string.
     *
     * @return bool
     * @syntax ? is a string
     */
    public function isAString()
    {
        $this->failIf(!is_string($this->data[0]));
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
        $this->failIf(!$this->isAnInstanceOf());
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
        $this->failIf(is_bool($this->data[0]));
    }

    /**
     * Assert a value is not an array.
     *
     * @return bool
     * @syntax ? is not an array
     */
    public function isNotAnArray()
    {
        $this->failIf(is_array($this->data[0]));
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
        $this->failIf(is_int($this->data[0]));
    }

    /**
     * Assert a value is not an object.
     *
     * @return bool
     * @syntax ? is not an object
     */
    public function isNotAnObject()
    {
        $this->failIf(is_object($this->data[0]));
    }

    /**
     * Assert that a value is not an integer or floating-point.
     *
     * @return bool
     * @syntax ? is not a number
     */
    public function isNotANumber()
    {
        $this->failIf(is_integer($this->data[0]) || is_float($this->data[0]));
    }

    /**
     * Assert a value is not a string.
     *
     * @return bool
     * @syntax ? is not a string
     */
    public function isNotAString()
    {
        $this->failIf(is_string($this->data[0]));
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
        $this->failIf($this->isAnInstanceOf());
    }

    /**
     * Assert a value is not null.
     *
     * @return bool
     * @syntax ? is not null
     */
    public function isNotNull()
    {
        $this->failIf(is_null($this->data[0]));
    }

    /**
     * Assert value is not a number or string that represents a number.
     *
     * @return bool
     * @syntax ? is not numeric
     */
    public function isNotNumeric()
    {
        $this->failIf(is_numeric($this->data[0]));
    }

    /**
     * Assert a value is null.
     *
     * @return bool
     * @syntax ? is null
     */
    public function isNull()
    {
        $this->failIf(!is_null($this->data[0]));
    }

    /**
     * Assert value is a number or string that represents a number.
     *
     * @return bool
     * @syntax ? is numeric
     */
    public function isNumeric()
    {
        $this->failIf(!is_numeric($this->data[0]));
    }

    protected function isAnInstanceOf()
    {
        $interfaces = class_implements($this->data[0]);

        if (is_string($this->data[0])) {
            return true;
        }
        return
            (get_class($this->data[0]) === $this->data[1]) ||
            is_subclass_of($this->data[0], $this->data[1]) ||
            array_key_exists($this->data[1], $interfaces);
    }
}
