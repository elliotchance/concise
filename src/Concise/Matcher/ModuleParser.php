<?php

namespace Concise\Matcher;

use InvalidArgumentException;

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
            $module->setDescription($tree['module']['description']);
        }

        return $module;
    }

    protected function error($message)
    {
        throw new InvalidArgumentException($message);
    }
}
