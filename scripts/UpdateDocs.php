<?php

require_once 'vendor/autoload.php';

use \Concise\Syntax\MatcherParser;
use \Concise\Services\MatcherSyntaxAndDescription;

updateReadme();
updateWikiAssertions();

function getAssertionsByTag()
{
	// generate the matchers doc
	$parser = \Concise\Syntax\MatcherParser::getInstance();
	$syntaxes = $parser->getAllMatcherDescriptions();

	$matchers = array();
	foreach($syntaxes as $syntax => $d) {
		foreach($d['tags'] as $tag) {
			$matchers[$tag][$syntax] = $d['description'];
		}
	}

	return $matchers;
}

function generateMarkdownList(array $syntaxes)
{
	$matchersDoc = '';
	foreach($syntaxes as $syntax => $description) {
		if(is_null($description)) {
			$matchersDoc .= "* `$syntax`\n";
		}
		else {
			$matchersDoc .= "* `$syntax` - $description\n";
		}
	}
	return "$matchersDoc\n";
}

function updateReadme()
{
	// load in the current README
	$readmeFile = __DIR__ . '/../README.md';
	$readme = file_get_contents($readmeFile);

	$matchers = getAssertionsByTag();

	$matchersDoc = '';
	ksort($matchers);
	foreach($matchers as $tag => $syntaxes) {
		ksort($syntaxes);
		$matchersDoc .= "### $tag\n\n";
		$matchersDoc .= generateMarkdownList($syntaxes);
	}

	$readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', "<!-- start matchers -->\n\n$matchersDoc\n<!-- end matchers -->", $readme);

	file_put_contents($readmeFile, $readme);
}

function updateWikiAssertions()
{
	$matchers = getAssertionsByTag();

	ksort($matchers);
	foreach($matchers as $tag => $syntaxes) {
		ksort($syntaxes);
		$matchersDoc = "# $tag\n\n";
		$matchersDoc .= generateMarkdownList($syntaxes);

		$wikiFile = __DIR__ . "/../wiki/Assertions-$tag.md";
		if(file_exists($wikiFile)) {
			$matchersDoc = preg_replace('/<!-- start assertions -->.*<!-- end assertions -->/ms', "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->",  file_get_contents($wikiFile));
		}
		else {
			$matchersDoc = "<!-- start assertions -->\n\n$matchersDoc\n<!-- end assertions -->";
		}
		file_put_contents($wikiFile, $matchersDoc);
	}
}
