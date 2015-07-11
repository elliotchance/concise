<?php

require_once 'vendor/autoload.php';

use Concise\Syntax\MatcherParser;

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

    return "* $syntax - $description\n";
}

/**
 * @return string
 */
function generateMarkdownList(array $matchers)
{
    $matchersDoc = '';
    foreach ($matchers as $matcher => $syntaxes) {
        for ($i = 0; $i < count($syntaxes); ++$i) {
            $matchersDoc .= generateMarkdownItem(
                $syntaxes[$i][0],
                $syntaxes[$i][1]
            );
        }
    }

    return "$matchersDoc\n";
}

function updateReadme()
{
    $matchers = getAssertionsByTag();

    $matchersDoc = '';
    ksort($matchers);
    foreach ($matchers as $tag => $syntaxes) {
        ksort($syntaxes);
        $matchersDoc .= "$tag\n";
        $matchersDoc .= str_repeat('_', strlen($tag)) . "\n\n";
        $matchersDoc .= generateMarkdownList($syntaxes);
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

/*function updateWikiAssertions()
{
    $matchers = getAssertionsByTag();

    ksort($matchers);
    foreach ($matchers as $tag => $syntaxes) {
        ksort($syntaxes);
        $matchersDoc = generateMarkdownList($syntaxes);
        $tag = str_replace(' ', '-', $tag);

        $wikiFile = __DIR__ . "/../doc/M";
        if (file_exists($wikiFile)) {
            $matchersDoc =
                preg_replace(
                    '/.. start assertions.*.. end assertions/ms',
                    ".. start assertions\n\n$matchersDoc\n.. end assertions",
                    file_get_contents($wikiFile)
                );
        } else {
            $matchersDoc =
                ".. start assertions\n\n$matchersDoc\n.. end assertions";
        }
        echo $matchersDoc;
        //file_put_contents($wikiFile, $matchersDoc);
    }
}*/

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
