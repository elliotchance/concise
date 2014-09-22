<?php

namespace Concise\Console;

use Concise\Services\SyntaxRenderer;
use DateTime;

class TestColors
{
    public function renderAll()
    {
        $renderer = new SyntaxRenderer();
        $lines = array(
            $renderer->render('? is null', array(null)),
            $renderer->render('? does not equal ?', array(true, false)),
            $renderer->render('? has key ? with value ?', array(array("foo" => 123), 'foo', 123)),
            $renderer->render('? is instance of ?', array(new DateTime(), 'DateTime')),
            $renderer->render('? equals ? within ?', array(1.57, 1.5, 0.5)),
            $renderer->render('? is instance of ?', array(function () {}, 'Closure')),
        );

        return "Some assertion examples:\n  " . implode("\n  ", $lines) . "\n\n";
    }
}
