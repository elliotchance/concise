<?php

namespace Concise\Spec;

use Closure;
use Concise\Core\TestCase;

/**
 * @group spec
 */
abstract class SpecTestCase extends TestCase
{
    protected $specs = [];

    public function describe($description, Closure $body)
    {
        $body();
    }

    function it($description, Closure $body)
    {
        $this->specs[$description] = [ $body ];
    }

    public function getSpecs()
    {
        $this->spec();
        return $this->specs;
    }

    abstract public function spec();

    /**
     * @dataProvider getSpecs
     */
    public function testSpecs(Closure $it)
    {
        $it($this);
    }
}
