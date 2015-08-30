<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;

class ObjectModule extends AbstractModule
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
}
