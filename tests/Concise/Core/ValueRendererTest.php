<?php

namespace Concise\Core;

use Concise\Console\ResultPrinter\Utilities\ColorText;
use Concise\Console\Theme\ThemeColor;

class ValueRendererTest extends TestCase
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
        $this->assert($this->renderer->render(123))->equals(123);
    }

    public function testFloatingPointValueRendersWithoutModification()
    {
        $this->assert($this->renderer->render(1.23))->equals('1.23');
    }

    public function testStringValueRendersWithDoubleQuotes()
    {
        $this->assert($this->renderer->render("abc"))->equals('"abc"');
    }

    public function testArrayValueRendersAsJson()
    {
        $this->assert($this->renderer->render(array(123, "abc")))
            ->equals("[\n  123,\n  \"abc\"\n]");
    }

    public function testObjectValueRendersAsJson()
    {
        $obj = new \stdClass();
        $obj->a = 123;
        $this->assert($this->renderer->render($obj))
            ->equals("stdClass:{\n  \"a\":123\n}");
    }

    public function testTrueValueRendersAsTrue()
    {
        $this->assert($this->renderer->render(true))->equals('true');
    }

    public function testFalseValueRendersAsFalse()
    {
        $this->assert($this->renderer->render(false))->equals('false');
    }

    public function testNullRendersAsNull()
    {
        $this->assert($this->renderer->render(null))->equals('null');
    }

    public function testResourceValueRendersAsResource()
    {
        $renderer = new ValueRenderer();
        $this->assertString($renderer->render(fopen('.', 'r')))
            ->startsWith("Resource id #");
    }

    public function testFunctionRendersAsString()
    {
        $this->assert(
            $this->renderer->render(
                function () {
                }
            )
        )->equals('function');
    }

    public function testRenderAllMethodWithZeroElements()
    {
        $this->assertString($this->renderer->renderAll(array()))->isEmpty;
    }

    public function testRenderAllMethodWithOneElement()
    {
        $this->assert($this->renderer->renderAll(array(1)))->equals('1');
    }

    public function testRenderAllMethodWithTwoElements()
    {
        $this->assert($this->renderer->renderAll(array(1, 2)))->equals('1, 2');
    }

    public function testRenderAllWithStrings()
    {
        $this->assert($this->renderer->renderAll(array('foo')))
            ->equals('"foo"');
    }

    protected function getThemeForValue(array $colors)
    {
        return $this->mock('Concise\Console\Theme\DefaultTheme')->stub(
            array('getTheme' => $colors)
        )->get();
    }

    public function testIntegersWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.integer' => ThemeColor::MAGENTA)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();
        $this->assert($this->renderer->render(123))
            ->equals($c->color(123, ThemeColor::MAGENTA));
    }

    public function testFloatingPointsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.float' => ThemeColor::RED)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();
        $this->assert($this->renderer->render(12.3))
            ->equals($c->color(12.3, ThemeColor::RED));
    }

    public function testStringsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.string' => ThemeColor::GREEN)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();
        $this->assert($this->renderer->render("12.3"))
            ->equals($c->color("\"12.3\"", ThemeColor::GREEN));
    }

    public function testClosureWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.closure' => ThemeColor::BLUE)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();
        $this->assert(
            $this->renderer->render(
                function () {
                }
            )
        )->equals($c->color("function", ThemeColor::BLUE));
    }

    public function testObjectKeysWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array(
                'value.string' => ThemeColor::GREEN,
                'value.integer' => 'yellow'
            )
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();

        $obj = new \stdClass();
        $obj->a = 123;
        $this->assertString($this->renderer->render($obj))
            ->contains($c->color('"a"', ThemeColor::GREEN));
    }

    public function testObjectValuesWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array(
                'value.string' => 'yellow',
                'value.integer' => ThemeColor::GREEN
            )
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();

        $obj = new \stdClass();
        $obj->a = 123;
        $this->assertString($this->renderer->render($obj))
            ->contains($c->color(123, ThemeColor::GREEN));
    }

    public function testArrayKeysWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.string' => ThemeColor::GREEN)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();

        $this->assertString($this->renderer->render(array('bar')))
            ->contains($c->color('"bar"', ThemeColor::GREEN));
    }

    public function testMultipleObjectValuesRendersAsJson()
    {
        $obj = new \stdClass();
        $obj->a = 123;
        $obj->b = 456;
        $this->assert($this->renderer->render($obj))->equals(
            "stdClass:{\n  \"a\":123,\n  \"b\":456\n}"
        );
    }

    public function testMultipleArrayValuesRendersAsJson()
    {
        $this->assert($this->renderer->render(array(1, 2)))
            ->equals("[\n  1,\n  2\n]");
    }

    public function testAssociativeArrayRendersAsJson()
    {
        $this->assert($this->renderer->render(array('foo' => 'bar')))
            ->equals("{\n  \"foo\":\"bar\"\n}");
    }

    public function testNumericArrayKeysAlwaysRenderAsStrings()
    {
        $this->assert($this->renderer->render(array(123 => 'bar')))
            ->equals("{\n  \"123\":\"bar\"\n}");
    }

    public function testNestedObjectsHideTypeHint()
    {
        $obj = new \stdClass();
        $obj->a = new \stdClass();
        $obj->a->b = 456;
        $this->assert($this->renderer->render($obj))
            ->equals("stdClass:{\n  \"a\":{\n    \"b\":456\n  }\n}");
    }

    public function testNullWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.null' => ThemeColor::GREEN)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();

        $this->assertString($this->renderer->render(null))
            ->contains($c->color('null', ThemeColor::GREEN));
    }

    public function testBooleanWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.boolean' => ThemeColor::RED)
        );
        $this->renderer->setTheme($theme);
        $c = new ColorText();

        $this->assertString($this->renderer->render(true))
            ->contains($c->color('true', ThemeColor::RED));
    }

    public function testDefaultMaximumDepthIsTen()
    {
        $this->assert($this->renderer->getMaximumDepth())->equals(10);
    }

    public function testMaximumDepthStopsRendererFromConsumingTooMuchMemory()
    {
        $renderer = $this->niceMock('Concise\Core\ValueRenderer')->stub(
            array('getMaximumDepth' => 2)
        )->get();
        $obj = json_decode('{"a":{"a":{"a":"b"}}}');
        $this->assert($renderer->render($obj))
            ->equals("stdClass:{\n  \"a\":{\n    \"a\":...\n  }\n}");
    }

    public function testMaximumDepthStopsRendererFromConsumingTooMuchMemoryForArrays(
    )
    {
        $renderer = $this->niceMock('Concise\Core\ValueRenderer')->stub(
            array('getMaximumDepth' => 2)
        )->get();
        $obj = json_decode('{"a":{"a":{"a":"b"}}}', true);
        $this->assert($renderer->render($obj))
            ->equals("{\n  \"a\":{\n    \"a\":...\n  }\n}");
    }

    public function testRenderAnythingConstant()
    {
        $this->assert($this->renderer->render(self::ANYTHING))
            ->equals('<ANYTHING>');
    }
}
