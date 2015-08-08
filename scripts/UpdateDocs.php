<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Concise\Matcher\Module;
use Concise\Matcher\Syntax;
use Concise\Syntax\MatcherParser;
use Concise\TestCase;

// Simulate starting a test case which will cause the default MatcherParser
// to load all the modules.
$testCase = new TestCase();
$testCase->setUpBeforeClass();

refreshKeywords();
updateReadme();
//updateWikiAssertions();

function getAssertionsByTag()
{
    $parser = MatcherParser::getInstance();
    $syntaxes = $parser->getAllMatcherDescriptions();

    $matchers = array();
    foreach ($syntaxes as $syntax => $d) {
        foreach ($d['tags'] as $tag) {
            $matchers[$tag][$d['matcher']][] =
                array($syntax, $d['description']);
        }
    }

    return $matchers;
}

function renderSyntax($syntax)
{
    return preg_replace_callback(
        "/\\?:?([a-zA-Z_,]+)?/",
        function ($m) {
            if ($m[0] == '?') {
                return "`mixed`_";
            }
            $types = explode(",", $m[1]);
            $r = array();
            foreach ($types as $type) {
                $r[] = "`$type`_";
            }
            return implode("\\|\\ ", $r);
        },
        $syntax
    );
}

function generateMarkdownItem($syntax, $description)
{
    $syntax = renderSyntax($syntax);

    if (is_null($description)) {
        return "* $syntax\n";
    }

    return "* $syntax - " . str_replace("\n", ' ', $description) . "\n";
}

/**
 * @return string
 */
function generateMarkdownList(Module $module)
{
    $matchersDoc = '';
    $syntaxes = [];
    foreach ($module->getSyntaxes() as $syntax) {
        $syntaxes[$syntax->getSyntax()] = $syntax;
    }
    ksort($syntaxes);
    /** @var Syntax $syntax */
    foreach ($syntaxes as $syntax) {
        $matchersDoc .= generateMarkdownItem(
            $syntax->getSyntax(),
            $syntax->getDescription()
        );
    }

    return "$matchersDoc\n";
}

function updateReadme()
{
    $matchersDoc = '';
    $modules = [];
    foreach (MatcherParser::getInstance()->getModules() as $module) {
        $modules[$module->getName()] = $module;
    }

    ksort($modules);
    foreach ($modules as $name => $module) {
        $matchersDoc .= "$name\n";
        $matchersDoc .= str_repeat('-', strlen($name)) . "\n\n";
        $matchersDoc .= generateMarkdownList($module);
    }

    $readmeFile = __DIR__ . '/../doc/matchers.rst';
    $readme = file_get_contents($readmeFile);
    $readme =
        preg_replace(
            '/\.\. start matchers.*\.\. end matchers/ms',
            ".. start matchers\n\n$matchersDoc\n.. end matchers",
            $readme
        );
    file_put_contents($readmeFile, $readme);
}

function refreshKeywords()
{
    $parser = MatcherParser::getInstance();
    $defines = ['on_error' => 'on error'];

    $all = array();
    foreach ($parser->getAllMatcherDescriptions() as $syntax => $description) {
        $simpleSyntax = preg_replace('/\\?(:[a-zA-Z0-9-,]+)/', '?', $syntax);
        foreach (explode('?', $simpleSyntax) as $part) {
            $p = trim($part);
            $all[str_replace(' ', '_', $p)] = $p;
        }
    }

    foreach ($all as $name => $value) {
        $defines[$name] = $value;
    }

    unset($defines['']);
    ksort($defines);

    $php =
        "<?php\n\nnamespace Concise;\n\nclass Keywords\n{\n    public static function load()\n    {    \n    }\n}\n\n";
    foreach ($defines as $k => $v) {
        $php .= "if (!defined(\"$k\")) {\n    define(\"$k\", \"$v\");\n}\n";
    }
    file_put_contents(__DIR__ . '/../src/Concise/Keywords.php', $php);
}
