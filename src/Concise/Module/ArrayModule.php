<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;

class ArrayModule extends AbstractModule
{
    public function getName()
    {
        return "Arrays";
    }

    /**
     * Assert an array does not have key and value item.
     *
     * @syntax array ?:array does not have item ?:array
     */
    public function doesNotHaveItem()
    {
        $this->failIf($this->itemExists($this->data));
    }

    /**
     * Assert an array does not have a key.
     *
     * @syntax array ?:array does not have key ?:int,string
     */
    public function doesNotHaveKey()
    {
        $this->failIf($this->keyExists($this->data[1], $this->data[0]));
    }

    /**
     * @syntax array ?:array does not have keys ?:array
     */
    public function doesNotHaveKeys()
    {
        $this->failIf($this->keysExist($this->data[1], $this->data[0]));
    }

    /**
     * Assert an array does not have any occurrences of the given value.
     *
     * @syntax array ?:array does not have value ?
     */
    public function doesNotHaveValue()
    {
        $this->failIf($this->valueExists($this->data[1], $this->data[0]));
    }

    /**
     * Assert an array has key and value item.
     *
     * @syntax array ?:array has item ?:array
     */
    public function hasItem()
    {
        $this->failIf(!$this->itemExists($this->data));
    }

    /**
     * Assert an array has all key and value items.
     *
     * @syntax array ?:array has items ?:array
     */
    public function hasItems()
    {
        if (count($this->data[1]) === 0) {
            return;
        }
        foreach ($this->data[1] as $key => $value) {
            $this->failIf(
                !$this->itemExists(
                    array($this->data[0], array($key => $value))
                )
            );
        }
    }

    /**
     * Assert an array has key, returns value.
     *
     * @syntax array ?:array has key ?:int,string
     * @throws DidNotMatchException
     * @return mixed
     */
    public function hasKey()
    {
        $this->failIf(!array_key_exists($this->data[1], $this->data[0]));

        return $this->data[0][$this->data[1]];
    }

    /**
     * Assert an array has several keys in any order.
     *
     * @syntax array ?:array has keys ?:array
     */
    public function hasKeys()
    {
        $this->failIf(!$this->keysExist($this->data[1], $this->data[0]));
    }

    /**
     * Assert an array has at least one occurrence of the given value.
     *
     * @syntax array ?:array has value ?
     */
    public function hasValue()
    {
        $this->failIf(!$this->valueExists($this->data[1], $this->data[0]));
    }

    /**
     * Assert an array has several values in any order.
     *
     * @syntax array ?:array has values ?:array
     */
    public function hasValues()
    {
        $keys = array_values($this->data[0]);
        foreach ($this->data[1] as $key) {
            $this->failIf((!in_array($key, $keys)));
        }
    }

    /**
     * Assert an array is empty (no elements).
     *
     * @syntax array ?:array is empty
     */
    public function isAnEmptyArray()
    {
        $this->failIf(!$this->arrayIsEmpty($this->data[0]));
    }

    /**
     * Assert an array is not empty (at least one element).
     *
     * @syntax array ?:array is not empty
     */
    public function isNotAnEmptyArray()
    {
        $this->failIf($this->arrayIsEmpty($this->data[0]));
    }

    /**
     * Assert that an array only has at least one element that is repeated.
     *
     * @syntax array ?:array is not unique
     */
    public function isNotUnique()
    {
        $this->failIf($this->arrayIsUnique($this->data[0]));
    }

    /**
     * Assert that an array only contains unique values.
     *
     * @syntax array ?:array is unique
     */
    public function isUnique()
    {
        $this->failIf(!$this->arrayIsUnique($this->data[0]));
    }

    /**
     * Assert an array is associative.
     *
     * @syntax array ?:array is associative
     */
    public function isAnAssociativeArray()
    {
        $this->failIf(!$this->arrayIsAssociative($this->data[0]));
    }

    /**
     * Assert an array is not associative.
     *
     * @syntax array ?:array is not associative
     */
    public function isNotAnAssociativeArray()
    {
        $this->failIf($this->arrayIsAssociative($this->data[0]));
    }

    /**
     * @param array $data
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

    protected function keysExist()
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
     * @return bool
     */
    protected function keyExists()
    {
        return array_key_exists($this->data[1], $this->data[0]);
    }

    protected function valueExists($value, array $array)
    {
        return in_array($value, $array);
    }

    /**
     * @param $arr
     * @return bool
     */
    protected function arrayIsAssociative(array $arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    /**
     * @param array $a
     * @return bool
     */
    protected function arrayIsEmpty(array $a)
    {
        return count($a) === 0;
    }

    /**
     * @param array $a
     * @return bool
     */
    protected function arrayIsUnique(array $a)
    {
        return $this->arrayIsEmpty($a) || count($a) === count(array_unique($a));
    }

    /**
     * Assert an array has a specific number of elements.
     *
     * @syntax array ?:array count is ?:int
     */
    public function arrayCountIs()
    {
    }
}
