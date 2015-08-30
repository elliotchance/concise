<?php

namespace Concise\Module;

use Concise\Core\DidNotMatchException;

class FileModule extends AbstractModule
{
    public function getName()
    {
        return "Files";
    }

    /**
     * Compare string value with the contents of a file.
     *
     * @return bool
     * @throws DidNotMatchException
     * @syntax ?:string equals file ?:string
     */
    public function stringEqualsFile()
    {
        if (!file_exists($this->data[1])) {
            throw new DidNotMatchException(
                "File '{$this->data[1]}' does not exist."
            );
        }

        return $this->data[0] == file_get_contents($this->data[1]);
    }

    /**
     * Compare string value with the contents of a file.
     *
     * @return bool
     * @throws DidNotMatchException
     * @syntax ?:string does not equal file ?:string
     */
    public function stringDoesNotEqualFile()
    {
        return !$this->stringEqualsFile();
    }
}
