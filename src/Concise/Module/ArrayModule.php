<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;

class ArrayModule extends AbstractMatcher
{
    public function getName()
    {
        return "Arrays";
    }

    /**
     * Assert an array does not have key and value item.
     *
     * @syntax ?:array does not have item ?:array
     * @return bool
     */
    public function doesNotHaveItem()
    {
        return !$this->hasItem();
    }

    /**
     * Assert an array does not have a key.
     *
     * @syntax ?:array does not have key ?:int,string
     * @return bool
     */
    public function doesNotHaveKey()
    {
        return !array_key_exists($this->data[1], $this->data[0]);
    }

    /**
     * @syntax ?:array does not have keys ?:array
     * @return bool
     */
    public function doesNotHaveKeys()
    {
        return !$this->hasKeys();
    }

    /**
     * Assert an array does not have any occurrences of the given value.
     *
     * @syntax ?:array does not contain ?
     * @syntax ?:array does not have value ?
     * @return bool
     */
    public function doesNotHaveValue()
    {
        return !$this->hasValue();
    }

    /**
     * Assert an array has key and value item.
     *
     * @syntax ?:array has item ?:array
     * @return bool
     */
    public function hasItem()
    {
        return $this->itemExists($this->data);
    }

    /**
     * Assert an array has all key and value items.
     *
     * @syntax ?:array has items ?:array
     * @return bool
     */
    public function hasItems()
    {
        if (count($this->data[1]) === 0) {
            return true;
        }
        foreach ($this->data[1] as $key => $value) {
            if (!$this->itemExists(
                array($this->data[0], array($key => $value))
            )
            ) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assert an array has key, returns value.
     *
     * @syntax ?:array has key ?:int,string
     * @return mixed
     * @nested
     */
    public function hasKey()
    {
        if (!array_key_exists($this->data[1], $this->data[0])) {
            throw new DidNotMatchException();
        }

        return $this->data[0][$this->data[1]];
    }

    /**
     * Assert an array has several keys in any order.
     *
     * @syntax ?:array has keys ?:array
     * @return bool
     */
    public function hasKeys()
    {
        $keys = array_keys($this->data[0]);
        foreach ($this->data[1] as $key) {
            if (!in_array($key, $keys)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assert an array has at least one occurrence of the given value.
     *
     * @syntax ?:array has value ?
     * @syntax ?:array contains ?
     * @return bool
     */
    public function hasValue()
    {
        return in_array($this->data[1], $this->data[0]);
    }

    /**
     * Assert an array has several values in any order.
     *
     * @syntax ?:array has values ?:array
     * @return bool
     */
    public function hasValues()
    {
        $keys = array_values($this->data[0]);
        foreach ($this->data[1] as $key) {
            if (!in_array($key, $keys)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Assert an array is empty (no elements).
     *
     * @syntax ?:array is empty array
     * @syntax ?:array is an empty array
     * @return bool
     */
    public function isAnEmptyArray()
    {
        return count($this->data[0]) === 0;
    }

    /**
     * Assert an array is not empty (at least one element).
     *
     * @syntax ?:array is not empty array
     * @syntax ?:array is not an empty array
     * @return bool
     */
    public function isNotAnEmptyArray()
    {
        return !$this->isAnEmptyArray();
    }

    /**
     * Assert that an array only has at least one element that is repeated.
     *
     * @syntax ?:array is not unique
     * @return bool
     */
    public function isNotUnique()
    {
        return !$this->isUnique();
    }

    /**
     * Assert that an array only contains unique values.
     *
     * @syntax ?:array is unique
     * @return bool
     */
    public function isUnique()
    {
        return count($this->data[0]) === count(array_unique($this->data[0]));
    }

    /**
     * Assert an array is associative.
     *
     * @syntax ?:array is an associative array
     * @return bool
     */
    public function isAnAssociativeArray()
    {
        $arr = $this->data[0];

        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * Assert an array is not associative.
     *
     * @syntax ?:array is not an associative array
     * @return bool
     */
    public function isNotAnAssociativeArray()
    {
        return !$this->isAnAssociativeArray();
    }

    /**
     * @return bool
     */
    protected function itemExists(array $data)
    {
        foreach ($data[0] as $key => $value) {
            if (array($key => $value) == $data[1]) {
                return true;
            }
        }

        return false;
    }
}
