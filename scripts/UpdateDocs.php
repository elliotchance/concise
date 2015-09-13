<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Concise\Core\Syntax;
use Concise\Module\AbstractModule;
use Concise\Syntax\ModuleManager;
use Concise\TestCase;

// Simulate starting a test case which will cause the default ModuleManager
// to load all the modules.
$testCase = new TestCase();
$testCase->setUpBeforeClass();

//refreshKeywords();
updateReadme();
updateBuilders();

function updateBuilders()
{
    $syntaxTree = array();
    foreach (ModuleManager::getInstance()->getModules() as $module) {
        foreach ($module->getSyntaxes() as $syntax) {
            $parts = explode('?', $syntax->getRawSyntax());
            $temp = &$syntaxTree;
            foreach ($parts as $part) {
                $part = trim($part);
                $temp = &$temp[$part];
            }
            $temp = null;
        }
    }

    $php = array();
    $trait = 'BaseAssertions';
    foreach ($syntaxTree as $k => $v) {
        foreach (array('assert' => false, 'verify' => true) as $method => $verify) {
            if (!isset($php[$trait])) {
                $php[$trait] = '';
            }
            $php[$trait] .= "\n\t/**\n\t * @return AssertionBuilder";
            if (null !== $v) {
                foreach ($v as $words => $s) {
                    $php[$trait] .=
                        '|' .
                        str_replace(' ', '', ucwords($words)) .
                        'Trait';
                }
                $php[$trait] .= "\n\t * @param mixed \$value";
            }

            $php[$trait] .=
                "\n\t */\n\tpublic function $method" .
                ucfirst($k) .
                "(";
            if (null !== $v) {
                $php[$trait] .= "\$valueOrFailureMessage, \$value = null";

                $php = a($v, $php);
            } else {
                $php[$trait] .= "\$failureMessage = null";
            }
            $php[$trait] .= ")\n\t{";
            if (null !== $v) {
                $php[$trait] .= "\n\t\tif (count(func_get_args()) > 1) {\n\t\t\t/** @noinspection PhpUndefinedMethodInspection */\n\t\t\treturn (new AssertionBuilder(\$this, \$valueOrFailureMessage, " . var_export($verify, true) . "))->";
                $php[$trait] .= ($k ? $k : '_') . "(";
                if (null !== $v) {
                    $php[$trait] .= "\$value";
                }
                $php[$trait] .= ");\n\t\t} else {\n\t\t\t/** @noinspection PhpUndefinedMethodInspection */\n\t\t\treturn (new AssertionBuilder(\$this, null, " . var_export($verify, true) . "))->";
                $php[$trait] .= ($k ? $k : '_') . "(";
                if (null !== $v) {
                    $php[$trait] .= "\$valueOrFailureMessage";
                }
                $php[$trait] .= ");\n\t\t}";
            } else {
                $php[$trait] .= "\n\t\t/** @noinspection PhpUndefinedMethodInspection */\n\t\treturn (new AssertionBuilder(\$this, \$failureMessage, " . var_export($verify, true) . "))->";
                $php[$trait] .= ($k ? $k : '_') . "();";
            }
            $php[$trait] .= "\n\t}\n";
        }
    }

    $out =
        "abstract class BaseAssertions extends PHPUnit_Framework_TestCase\n{" .
        $php['BaseAssertions'] .
        "}\n\n";
    ksort($php);
    foreach ($php as $trait => $methods) {
        if ($trait == 'BaseAssertions') {
            continue;
        }
        $out .= "/**$methods */\nclass {$trait}Trait\n{\n}\n\n";
    }

    file_put_contents(
        __DIR__ . '/../src/Concise/Core/BaseAssertions.php',
        "<?php\n\nnamespace Concise\\Core;\n\nuse PHPUnit_Framework_TestCase;\n\n" . str_replace("\t", '    ', $out)
    );
}

/**
 * @param $v
 * @param $php
 * @return array
 */
function a($v, $php)
{
    foreach ($v as $words => $s) {
        $trait2 = str_replace(' ', '', ucwords($words));
        if (is_array($s)) {
            $php[$trait2] = "\n * @method null";
            foreach ($s as $words2 => $s2) {
                if ($words2) {
                    $php[$trait2] .=
                        '|' .
                        str_replace(' ', '', ucwords($words2)) .
                        'Trait';
                }
            }

            unset($s['']);
            if (count($s) > 0) {
                $php = a($s, $php);
            }
        } else {
            $php[$trait2] = "\n * @property null";
        }
        $php[$trait2] .= " ";
        $php[$trait2] .= lcfirst($trait2);

        if (is_array($s)) {
            $php[$trait2] .= "(\$value)";
        }
        $php[$trait2] .= "\n";
    }
    return $php;
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
function generateMarkdownList(AbstractModule $module)
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
    foreach (ModuleManager::getInstance()->getModules() as $module) {
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
    $parser = ModuleManager::getInstance();
    $defines = ['on_error' => 'on error'];

    $all = array();
    foreach ($parser->getModules() as $module) {
        foreach ($module->getSyntaxes() as $syntax) {
            foreach (explode('?', $syntax->getRawSyntax()) as $part) {
                $p = trim($part);
                $all[str_replace(' ', '_', $p)] = $p;
            }
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
}
