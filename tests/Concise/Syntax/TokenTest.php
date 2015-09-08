<?php

namespace Concise\Syntax;

use Concise\TestCase;

class TokenTest extends TestCase
{
    public function testDefaultValueIsNull()
    {
        $attribute = new Token();
        /*$this->assert($attribute->getValue(), is_null);*/
        $this->aassert($attribute->getValue())->isNull;
    }

    public function testValueCanBeProvidedThroughConstructor()
    {
        $attribute = new Token\Value('abc');
        /*$this->assert($attribute->getValue(), equals, 'abc');*/
        $this->aassert($attribute->getValue())->equals('abc');
    }

    public function testRenderAsStringUsesValue()
    {
        $attribute = new Token\Value('abc');
        /*$this->assert((string)$attribute, equals, 'abc');*/
        $this->aassert((string)$attribute)->equals('abc');
    }
}
