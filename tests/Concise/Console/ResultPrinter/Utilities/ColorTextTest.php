<?php

namespace Concise\Console\ResultPrinter\Utilities;

use Concise\Console\Theme\ThemeColor;
use Concise\Core\TestCase;

/**
 * @group #339
 */
class ColorTextTest extends TestCase
{
    public function colorTests()
    {
        return array(
            // No color
            'a01' => array('foo', 'foo', ThemeColor::NONE, ThemeColor::NONE),
            'a02' => array('bar', 'bar', ThemeColor::NONE, ThemeColor::NONE),

            // Only foreground
            'b01' => array(
                "\e[31mfoo\e[0m",
                'foo',
                ThemeColor::RED,
                ThemeColor::NONE
            ),
            'b02' => array(
                "\e[31mbar\e[0m",
                'bar',
                ThemeColor::RED,
                ThemeColor::NONE
            ),
            'b03' => array(
                "\e[32mfoo\e[0m",
                'foo',
                ThemeColor::GREEN,
                ThemeColor::NONE
            ),
            'b04' => array(
                "\e[33mfoo\e[0m",
                'foo',
                ThemeColor::YELLOW,
                ThemeColor::NONE
            ),
            'b05' => array(
                "\e[34mfoo\e[0m",
                'foo',
                ThemeColor::BLUE,
                ThemeColor::NONE
            ),
            'b06' => array(
                "\e[35mfoo\e[0m",
                'foo',
                ThemeColor::MAGENTA,
                ThemeColor::NONE
            ),
            'b07' => array(
                "\e[36mfoo\e[0m",
                'foo',
                ThemeColor::CYAN,
                ThemeColor::NONE
            ),

            // Only background
            'c01' => array(
                "\e[41mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::RED
            ),
            'c02' => array(
                "\e[41mbar\e[0m",
                'bar',
                ThemeColor::NONE,
                ThemeColor::RED
            ),
            'c03' => array(
                "\e[42mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::GREEN
            ),
            'c04' => array(
                "\e[43mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::YELLOW
            ),
            'c05' => array(
                "\e[44mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::BLUE
            ),
            'c06' => array(
                "\e[45mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::MAGENTA
            ),
            'c07' => array(
                "\e[46mfoo\e[0m",
                'foo',
                ThemeColor::NONE,
                ThemeColor::CYAN
            ),

            // Foreground and background
            'd01' => array(
                "\e[34;41mfoo\e[0m",
                'foo',
                ThemeColor::BLUE,
                ThemeColor::RED
            ),
            'd02' => array(
                "\e[33;42mbar\e[0m",
                'bar',
                ThemeColor::YELLOW,
                ThemeColor::GREEN
            ),
        );
    }

    /**
     * @param $expected
     * @param $text
     * @param $textColor
     * @param $backgroundColor
     * @dataProvider colorTests
     */
    public function testColors($expected, $text, $textColor, $backgroundColor)
    {
        $color = new ColorText();
        $this->assert($color->color($text, $textColor, $backgroundColor))
            ->exactlyEquals($expected);
    }

    public function testDefaultBackgroundColor()
    {
        $color = new ColorText();
        $this->assert($color->color('foo', ThemeColor::NONE))
            ->exactlyEquals('foo');
    }

    /**
     * @param $expected
     * @param $text
     * @param $textColor
     * @param $backgroundColor
     * @dataProvider colorTests
     */
    public function testClean($colored, $expected, $textColor, $backgroundColor)
    {
        $color = new ColorText();

        $this->assert($color->clean($colored))
            ->exactlyEquals($expected);
    }
}
