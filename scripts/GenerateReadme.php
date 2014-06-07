<?php

require_once 'vendor/autoload.php';

// load in the current README
$readmeFile = __DIR__ . '/../README.md';
$readme = file_get_contents($readmeFile);

// generate the matchers doc
$parser = \Concise\Syntax\MatcherParser::getInstance();
$syntaxes = $parser->getAllSyntaxes();
$matchersDoc = '';
foreach($syntaxes as $syntax) {
	$matchersDoc .= "* `$syntax`\n";
}

$readme = preg_replace('/<!-- start matchers -->.*<!-- end matchers -->/ms', $matchersDoc, $readme);

file_put_contents($readmeFile, $readme);
