<?php

require_once 'vendor/autoload.php';

use Concise\Syntax\MatcherParser;

refreshKeywords();
updateReadme();
updateWikiAssertions();

function getAssertionsByTag()
{
    $parser = \Concise\Syntax\MatcherParser::getInstance();
    $syntaxes = $parser->getAllMatcherDescriptions();

    $matchers = array();
    foreach ($syntaxes as $syntax => $d) {
        foreach ($d['tags'] as $tag) {
            $matchers[$tag][$d['matcher']][] = array($syntax, $d['description']);
        }
    }

    return $matchers;
}

function generateMarkdownItem($syntax, $description)
{
    if (is_null($description)) {
        return "* `$syntax`\n";
    }

    return "* `$syntax` - $description\n";
}

/**
 * @return string
 */
function generateMarkdownList(array $matchers)
{
    $matchersDoc = '';
    foreach ($matchers as $matcher => $syntaxes) {
        for ($i = 0; $i < count($syntaxes); ++$i) {
            $matchersDoc .= generateMarkdownItem($syntaxes[$i][0], $syntaxes[$i][1]);
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
        $matchersDoc .= "### $tag\n\n";
        $matchersDoc .= generateMarkdownList($syntaxes);
    }

    $readmeFile = __DIR__ . '/../README.md';
    $readme = file_get_contents($readmeFile);
    $readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', "<!-- start matchers -->\n\n$matchersDoc\n<!-- end matchers -->", $readme);
    file_put_contents($readmeFile, $readme);

    $readmeFile = __DIR__ . '/../wiki/Home.md';
    $readme = file_get_contents($readmeFile);
    $readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', "<!-- start matchers -->\n\n$matchersDoc\n<!-- end matchers -->", $readme);
    file_put_contents($readmeFile, $readme);
}

function updateWikiAssertions()
{
    $matchers = getAssertionsByTag();

    ksort($matchers);
    foreach ($matchers as $tag => $syntaxes) {
        ksort($syntaxes);
        $matchersDoc = generateMarkdownList($syntaxes);
        $tag = str_replace(' ', '-', $tag);

        $wikiFile = __DIR__ . "/../wiki/Assertions-for-$tag.md";
        if (file_exists($wikiFile)) {
            $matchersDoc = preg_replace('/<!-- start assertions -->.*<!-- end assertions -->/ms', "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->", file_get_contents($wikiFile));
        } else {
            $matchersDoc = "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->";
        }
        file_put_contents($wikiFile, $matchersDoc);
    }
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
    $d = var_export($defines, true);

    $php = <<<EOF
<?php

namespace Concise;

class Keywords
{
    public static \$defines = $d;

    public static function load()
    {
        foreach (self::\$defines as \$k => \$v) {
            if (!defined(\$k)) {
                define(\$k, \$v);
            }
        }
    }
}
EOF;
    file_put_contents(__DIR__ . '/../src/Concise/Keywords.php', $php);
}
