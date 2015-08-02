<?php

namespace Concise\Matcher;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

class ModuleLoader
{
    public function loadFromYaml($yaml)
    {
        $tree = Yaml::parse($yaml);
        if (!array_key_exists('module', $tree)) {
            throw new InvalidArgumentException(
                "Missing 'module' at Yaml root."
            );
        }
        return new Module();
    }
}
