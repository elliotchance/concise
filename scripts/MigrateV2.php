<?php

require_once __DIR__ . '/../vendor/autoload.php';

$file = file_get_contents($argv[1]);
$file = preg_replace_callback(
    '/(\s*)\\$this\\->assert([^\\(]*)\\((.*)\\);/msU',
    function ($v) {
        $r = "$v[1]/*\$this->assert$v[2]($v[3]);*/$v[1]";
        if ($v[2]) {
            $r .= "\$this->aassertFailure(";
        }
        $r .= "\$this->aassert!";
        $parts = explode(',', rtrim($v[3]));
        if (count($parts) % 2 == 0) {
            $r .= ucfirst($parts[0]);
            $parts = array_slice($parts, 1);
        }
        $r .= $v[2] . "(";
        for ($i = 0; $i < count($parts); $i += 2) {
            $method = trim($parts[$i + 1]);
            $method = lcfirst(
                str_replace(' ', '', ucwords(str_replace('_', ' ', $method)))
            );
            $r .= trim($parts[$i]) . ')->' . $method . '(';
        }
        if ($v[2]) {
            $r .= ")";
        }
        return rtrim($r, '->(') . ";";
    },
    $file
);

echo $file;
//file_put_contents($argv[1], $file);
