<?php

namespace Concise\Matcher;

use InvalidArgumentException;

class ModuleLoader
{
    public function load(array $tree)
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

        return new Module('');
    }

    protected function error($message)
    {
        throw new InvalidArgumentException($message);
    }
}
