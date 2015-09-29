<?php

namespace Concise\Core;

use Colors\Color;

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
        $theme = $this->getThemeForValue(array('value.integer' => 'magenta'));
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render(123))
            ->equals((string)$c(123)->magenta);
    }

    public function testFloatingPointsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(array('value.float' => 'red'));
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render(12.3))
            ->equals((string)$c(12.3)->red);
    }

    public function testStringsWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(array('value.string' => 'green'));
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert($this->renderer->render("12.3"))
            ->equals((string)$c("\"12.3\"")->green);
    }

    public function testClosureWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(array('value.closure' => 'blue'));
        $this->renderer->setTheme($theme);
        $c = new Color();
        $this->assert(
            $this->renderer->render(
                function () {
                }
            )
        )->equals((string)$c("function")->blue);
    }

    public function testObjectKeysWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.string' => 'green', 'value.integer' => 'yellow')
        );
        $this->renderer->setTheme($theme);
        $c = new Color();

        $obj = new \stdClass();
        $obj->a = 123;
        $this->assertString($this->renderer->render($obj))
            ->contains((string)$c('"a"')->green);
    }

    public function testObjectValuesWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(
            array('value.string' => 'yellow', 'value.integer' => 'green')
        );
        $this->renderer->setTheme($theme);
        $c = new Color();

        $obj = new \stdClass();
        $obj->a = 123;
        $this->assertString($this->renderer->render($obj))
            ->contains((string)$c(123)->green);
    }

    public function testArrayKeysWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(array('value.string' => 'green'));
        $this->renderer->setTheme($theme);
        $c = new Color();

        $this->assertString($this->renderer->render(array('bar')))
            ->contains((string)$c('"bar"')->green);
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
        $theme = $this->getThemeForValue(array('value.null' => 'green'));
        $this->renderer->setTheme($theme);
        $c = new Color();

        $this->assertString($this->renderer->render(null))
            ->contains((string)$c('null')->green);
    }

    public function testBooleanWillBeColoredWhenAThemeIsSpecified()
    {
        $theme = $this->getThemeForValue(array('value.boolean' => 'red'));
        $this->renderer->setTheme($theme);
        $c = new Color();

        $this->assertString($this->renderer->render(true))
            ->contains((string)$c('true')->red);
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
