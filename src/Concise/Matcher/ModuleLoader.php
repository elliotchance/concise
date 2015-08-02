<?php

namespace Concise\Matcher;

use Symfony\Component\Yaml\Yaml;

class ModuleLoader
{
    public function loadFromYaml($yaml)
    {
        Yaml::parse($yaml);
        return new Module();
    }
}
