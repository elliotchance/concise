<?php

require_once 'vendor/autoload.php';

use \Concise\Syntax\MatcherParser;
use \Concise\Services\MatcherSyntaxAndDescription;

// load in the current README
$readmeFile = __DIR__ . '/../README.md';
$readme = file_get_contents($readmeFile);

// generate the matchers doc
$parser = \Concise\Syntax\MatcherParser::getInstance();
$syntaxes = $parser->getAllMatcherDescriptions();

$matchers = array();
foreach($syntaxes as $syntax => $d) {
	foreach($d['tags'] as $tag) {
		$matchers[$tag][$syntax] = $d['description'];
	}
}

$matchersDoc = '';
ksort($matchers);
foreach($matchers as $tag => $syntaxes) {
	ksort($syntaxes);
	$matchersDoc .= "### $tag\n\n";
	foreach($syntaxes as $syntax => $description) {
		if(is_null($description)) {
			$matchersDoc .= "* `$syntax`\n";
		}
		else {
			$matchersDoc .= "* `$syntax` - $description\n";
		}
	}
	$matchersDoc .= "\n";
}

$readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', "<!-- start matchers -->\n\n$matchersDoc\n<!-- end matchers -->", $readme);

file_put_contents($readmeFile, $readme);
