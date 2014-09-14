<?php

namespace Concise\Services;

use Colors\Color;
use Concise\Console\Theme\DefaultTheme;

class ValueRendererTest extends \Concise\TestCase
{
    /** @var ValueRenderer */
    protected $renderer;

    public function setUp()
    {
        parent::setUp();
        $this->renderer = new ValueRenderer();
    }

    public function testIntegerValueRendersWithoutModification()
    {
        $this->assert($this->renderer->render(123), equals, 123);
    }

    public function testFloatingPointValueRendersWithoutModification()
    {
        $this->assert($this->renderer->render(1.23), equals, '1.23');
    }

    public function testStringValueRendersWithDoubleQuotes()
    {
        $this->assert($this->renderer->render("abc"), equals, '"abc"');
    }

    public function testArrayValueRendersAsJson()
    {
        $this->assert($this->renderer->render(array(123, "abc")), equals, '[123,"abc"]');
    }

    public function testObjectValueRendersAsJson()
    {
        $obj = new \stdClass();
        $obj->a = 123;
        $this->assert($this->renderer->render($obj), equals, 'stdClass:{"a":123}');
    }

    public function testTrueValueRendersAsTrue()
    {
        $this->assert($this->renderer->render(true), equals, 'true');
    }

    public function testFalseValueRendersAsFalse()
    {
        $this->assert($this->renderer->render(false), equals, 'false');
    }

    public function testNullRendersAsNull()
    {
        $this->assert($this->renderer->render(null), equals, 'null');
    }

    public function testResourceValueRendersAsResource()
    {
        $renderer = new ValueRenderer();
        $this->str = $renderer->render(fopen('.', 'r'));
        $this->assert('str starts with "Resource id #"');
    }

    public function testFunctionRendersAsString()
    {
        $this->assert($this->renderer->render(function () {}), equals, 'function');
    }

    public function testRenderAllMethodWithZeroElements()
    {
        $this->assert($this->renderer->renderAll(array()), equals, '');
    }

    public function testRenderAllMethodWithOneElement()
    {
        $this->assert($this->renderer->renderAll(array(1)), equals, '1');
    }

    public function testRenderAllMethodWithTwoElements()
    {
        $this->assert($this->renderer->renderAll(array(1, 2)), equals, '1, 2');
    }

    public function testRenderAllWithStrings()
    {
        $this->assert($this->renderer->renderAll(array('foo')), equals, '"foo"');
    }

    protected function getThemeForValue($name, $color)
    {
        return $this->mock('Concise\Console\Theme\DefaultTheme')
                      ->stub(array('getTheme' => array(
                        $name => $color,
                        )))
                      ->get();
    }

    public function testIntegersWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue('value.integer', 'magenta');
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render(123), equals, (string) $c(123)->magenta);
    }

    public function testFloatingPointsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue('value.float', 'red');
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render(12.3), equals, (string) $c(12.3)->red);
    }

    public function testStringsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue('value.string', 'green');
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render("12.3"), equals, (string) $c("\"12.3\"")->green);
    }

    public function testClosureWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue('value.closure', 'blue');
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render(function () {}), equals, (string) $c("function")->blue);
    }
}
