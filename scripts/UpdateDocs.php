<?php

$autoloadFiles = [
    __DIR__ . '/../vendor/autoload.php',
    'vendor/autoload.php',
];

foreach ($autoloadFiles as $autoload) {
    if (file_exists($autoload)) {
        require_once($autoload);
        break;
    }
}

$xml = simplexml_load_file('phpunit.xml');
$bootstrapFile = (string)$xml['bootstrap'];

require_once($bootstrapFile);

use Concise\Core\ModuleManager;
use Concise\Core\Syntax;
use Concise\Module\AbstractModule;
use Concise\Core\TestCase;

// Simulate starting a test case which will cause the default ModuleManager
// to load all the modules.
$testCase = new TestCase();
$testCase->setUpBeforeClass();

updateReadme();
updateBuilders();

function getShortName($trait)
{
    static $shortNames = [];
    static $c = 0;
    if (!array_key_exists($trait, $shortNames)) {
        if ($c < 26) {
            $shortNames[$trait] = chr(ord('A') + $c);
        } else {
            $shortNames[$trait] = chr(ord('A') + ($c / 26)) . chr(ord('a') + ($c % 26));
        }

        if ($shortNames[$trait] == 'Do' || $shortNames[$trait] == 'If') {
            unset($shortNames[$trait]);
            ++$c;
            return getShortName($trait);
        }
    }

    ++$c;
    return $shortNames[$trait];
}

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
    $header = "/**";
    foreach ($syntaxTree as $k => $v) {
        foreach (array('assert' => false, 'verify' => true) as $method => $verify) {
            $header .= "\n * @method AssertionBuilder";
            if (null !== $v) {
                foreach ($v as $words => $s) {
                    $header .=
                        '|' .
                        getShortName(str_replace(' ', '', ucwords($words)));
                }
            }
            $header .= " $method" . ucfirst($k) .
                "(\$valueOrFailureMessage, \$value = null)";

            if (null !== $v) {
                $php = a($v, $php);
            }
        }
    }

    $out = $header .
        "\n */\nabstract class BaseAssertions extends PHPUnit_Framework_TestCase\n{" .
        "\n}\n\n";
    ksort($php);
    foreach ($php as $trait => $methods) {
        $out .= "/**$methods */\nclass " . getShortName($trait) . "\n{\n}\n\n";
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
        $php[$trait2] = "\n * $trait2";
        if (is_array($s)) {
            $php[$trait2] .= "\n * @method null";
            foreach ($s as $words2 => $s2) {
                if ($words2) {
                    $php[$trait2] .=
                        '|' .
                        getShortName(str_replace(' ', '', ucwords($words2)));
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

    $readmeFile = __DIR__ . '/../doc/assertions.rst';
    $readme = file_get_contents($readmeFile);
    $readme =
        preg_replace(
            '/\.\. start matchers.*\.\. end matchers/ms',
            ".. start matchers\n\n$matchersDoc\n.. end matchers",
            $readme
        );
    file_put_contents($readmeFile, $readme);
}
