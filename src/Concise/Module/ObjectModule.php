<?php

namespace Concise\Module;

use Concise\Matcher\AbstractMatcher;
use Concise\Matcher\DidNotMatchException;

class ObjectModule extends AbstractMatcher
{
    public function getName()
    {
        return "Objects and Classes";
    }

    /**
     * Assert that an object does not have a property.
     *
     * @return bool
     * @syntax ?:object does not have property ?:string
     */
    public function doesNotHaveProperty()
    {
        return !array_key_exists($this->data[1], (array)$this->data[0]);
    }

    /**
     * Assert that an object has a property. Returns the properties value.
     *
     * @return mixed
     * @throws DidNotMatchException
     * @syntax ?:object has property ?:string
     * @nested
     */
    public function hasProperty()
    {
        if (!array_key_exists($this->data[1], (array)$this->data[0])) {
            throw new DidNotMatchException();
        }

        return $this->data[0]->{$this->data[1]};
    }

    /**
     * Assert that an object has a property with a specific exact value.
     *
     * @return bool
     * @syntax ?:object has property ?:string with exact value ?
     */
    public function hasPropertyWithExactValue()
    {
        if (method_exists($this->data[0], '__get') && $this->data[0]->{$this->data[1]}) {
            return ($this->data[0]->{$this->data[1]} == $this->data[2]);
        }
        return array_key_exists($this->data[1], (array)$this->data[0]) &&
        ($this->data[0]->{$this->data[1]} === $this->data[2]);
    }

    /**
     * Assert that an object has a property with a specific value.
     *
     * @return bool
     * @syntax ?:object has property ?:string with value ?
     */
    public function hasPropertyWithValue()
    {
        if (method_exists($this->data[0], '__get') && $this->data[0]->{$this->data[1]}) {
            return ($this->data[0]->{$this->data[1]} == $this->data[2]);
        }
        return array_key_exists(
            $this->data[1],
            (array)$this->data[0]
        ) && ($this->data[0]->{$this->data[1]} == $this->data[2]);
    }
}
