<?php

namespace Concise\Matcher;

use InvalidArgumentException;
use Symfony\Component\Yaml\Yaml;

class ModuleParser
{
    public function parse(array $tree)
    {
        if (!array_key_exists('module', $tree)) {
            $this->error("Missing 'module' at root.");
        }
        if (!array_key_exists('name', $tree['module'])) {
            $this->error("A module must have a name defined.");
        }
        if (!is_string($tree['module']['name'])) {
            $this->error("The module name must be a string.");
        }

        $module = new Module($tree['module']['name']);
        if (array_key_exists('description', $tree['module'])) {
            if (!is_string($tree['module']['description'])) {
                $this->error("The module description must be a string.");
            }
            $module->setDescription($tree['module']['description']);
        }

        if (!array_key_exists('syntaxes', $tree['module'])) {
            $this->error("A module must have syntaxes.");
        }
        if (!is_array($tree['module']['syntaxes'])) {
            $this->error("The module syntaxes must be an array.");
        }

        return $module;
    }

    public function parseFromFile($filePath)
    {
        return $this->parse(Yaml::parse(file_get_contents($filePath)));
    }

    protected function error($message)
    {
        throw new InvalidArgumentException($message);
    }
}
