<?php

require_once 'vendor/autoload.php';

use \Concise\Syntax\MatcherParser;
use \Concise\Services\MatcherSyntaxAndDescription;

// load in the current README
$readmeFile = __DIR__ . '/../README.md';
$readme = file_get_contents($readmeFile);

// generate the matchers doc
$parser = \Concise\Syntax\MatcherParser::getInstance();
$syntaxes = $parser->getAllSyntaxes();

$matchersDoc = '';
foreach($syntaxes as $syntax => $description) {
	if(!is_null($description)) {
		$matchersDoc .= "* `$syntax` - $description\n";
	}
	else {
		$matchersDoc .= "* `$syntax`\n";
	}
}

$readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', "<!-- start matchers -->\n\n$matchersDoc\n<!-- end matchers -->", $readme);

file_put_contents($readmeFile, $readme);
