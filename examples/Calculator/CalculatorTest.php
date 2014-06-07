<?php

class Calculator
{
    /**
     * @param integer $a
     * @param integer $b
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $this->assertEquals(8, $calc->add(5, 3));
    }
}

