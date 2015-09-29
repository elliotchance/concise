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
     * @syntax object ?:object does not have property ?:string
     */
    public function doesNotHaveProperty()
    {
        $this->failIf(array_key_exists($this->data[1], (array)$this->data[0]));
    }

    /**
     * Assert that an object has a property. Returns the properties value.
     *
     * @return mixed
     * @throws DidNotMatchException
     * @syntax object ?:object has property ?:string
     */
    public function hasProperty()
    {
        if (!array_key_exists($this->data[1], (array)$this->data[0])) {
            throw new DidNotMatchException();
        }

        return $this->data[0]->{$this->data[1]};
    }

    /**
     * Assert than an object is not a class or subclass.
     *
     * @syntax ?:object,class is not an instance of ?:class
     */
    public function isNotAnInstanceOf()
    {
        $this->failIf($this->isAnInstanceOf());
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

    /**
     * Assert an objects class or subclass.
     *
     * @return bool
     * @syntax ?:object,class is an instance of ?:class
     */
    public function isInstanceOf()
    {
        $this->failIf(!$this->isAnInstanceOf());
    }
}
