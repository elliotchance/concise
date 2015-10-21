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
