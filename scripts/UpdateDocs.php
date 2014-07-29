<?php

require_once 'vendor/autoload.php';

use \Concise\Syntax\MatcherParser;
use \Concise\Services\MatcherSyntaxAndDescription;

updateReadme();
updateWikiAssertions();

function getAssertionsByTag()
{
	$parser = \Concise\Syntax\MatcherParser::getInstance();
	$syntaxes = $parser->getAllMatcherDescriptions();

	$matchers = array();
	foreach($syntaxes as $syntax => $d) {
		foreach($d['tags'] as $tag) {
			$matchers[$tag][$d['matcher']][] = array($syntax, $d['description']);
		}
	}

	return $matchers;
}

function generateMarkdownItem($syntax, $description, $indent = '*')
{
	if(is_null($description)) {
		return "$indent `$syntax`\n";
	}
	return "$indent `$syntax` - $description\n";
}

/**
 * @return string
 */
function generateMarkdownList(array $matchers)
{
	$matchersDoc = '';
	foreach($matchers as $matcher => $syntaxes) {
		$matchersDoc .= generateMarkdownItem($syntaxes[0][0], $syntaxes[0][1]);
		for($i = 1; $i < count($syntaxes); ++$i) {
			$matchersDoc .= generateMarkdownItem($syntaxes[$i][0], null, '  *');
		}
	}
	return "$matchersDoc\n";
}

function updateReadme()
{
	$matchers = getAssertionsByTag();

	$matchersDoc = '';
	ksort($matchers);
	foreach($matchers as $tag => $syntaxes) {
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
	foreach($matchers as $tag => $syntaxes) {
		ksort($syntaxes);
		$matchersDoc = generateMarkdownList($syntaxes);

		$wikiFile = __DIR__ . "/../wiki/Assertions-for-$tag.md";
		if(file_exists($wikiFile)) {
			$matchersDoc = preg_replace('/<!-- start assertions -->.*<!-- end assertions -->/ms', "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->", file_get_contents($wikiFile));
		}
		else {
			$matchersDoc = "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->";
		}
		file_put_contents($wikiFile, $matchersDoc);
	}
}
