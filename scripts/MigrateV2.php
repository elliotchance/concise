<?php

// Use something like:
// find tests -name "*Test.php" | xargs -n1 php scripts/MigrateV2.php

require_once __DIR__ . '/../vendor/autoload.php';

$file = file_get_contents($argv[1]);
$file = preg_replace_callback(
    '/(\s*)\\$this\\->assert\\((.*)\\);/msU',
    function ($v) {
        $r = "$v[1]/*\$this->assert($v[2]);*/$v[1]";
        $r .= "\$this->assert";
        $parts = explode(',', rtrim($v[2]));
        if (preg_match('/^[a-z]+$/', $parts[0])) {
            $r .= ucfirst($parts[0]);
            $parts = array_slice($parts, 1);
        }
        $r .= "(";
        for ($i = 0; $i < count($parts); $i += 2) {
            if (!isset($parts[$i + 1])) {
                $method = '';
            } else {
                $method = trim($parts[$i + 1]);
            }
            $method = lcfirst(
                str_replace(' ', '', ucwords(str_replace('_', ' ', $method)))
            );
            $r .= trim($parts[$i]);
            if ($method) {
                $r .= ')->' . $method . '(';
            }
        }
        $r .= ")";
        return preg_replace('/\\(\\)$/', '', $r) . ";";
    },
    $file
);

//echo $file;
file_put_contents($argv[1], $file);
