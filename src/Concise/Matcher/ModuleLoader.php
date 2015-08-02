<?php

namespace Concise\Matcher;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

class ModuleLoader
{
    public function loadFromYaml($yaml)
    {
        $tree = Yaml::parse($yaml);
        if (!is_array($tree)) {
            throw new InvalidArgumentException("Yaml root must be an array.");
        }
        if (!array_key_exists('module', $tree)) {
            throw new InvalidArgumentException(
                "Missing 'module' at Yaml root."
            );
        }
        if (!array_key_exists('name', $tree['module'])) {
            throw new InvalidArgumentException("A module must have a name defined.");
        }
        return new Module();
    }
}
