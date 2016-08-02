<?php

// Resolve auto-loader path
$autoloaders = array(
    // Phar/repo path
    __DIR__ . '/../vendor/autoload.php',
    // Composer path
    __DIR__ . '/../../../autoload.php',
);

foreach ($autoloaders as $autoloader) {
    if (file_exists($autoloader)) {
        define('CONCISE_AUTOLOADER', $autoloader);
        break;
    }
}

if (!defined('CONCISE_AUTOLOADER')) {
    fprintf(STDERR, "%s\n", 'Missing auto-loader (try `composer install`?)');
    exit(1);
}

unset($autoloaders, $autoloader);

require_once(CONCISE_AUTOLOADER);
