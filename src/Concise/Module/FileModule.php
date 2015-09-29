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
     * @throws DidNotMatchException
     * @syntax file ?:string equals ?:string
     */
    public function stringEqualsFile()
    {
        $this->failIf(!$this->compareFileWithString());
    }

    /**
     * Compare string value with the contents of a file.
     *
     * @throws DidNotMatchException
     * @syntax file ?:string does not equal ?:string
     */
    public function stringDoesNotEqualFile()
    {
        $this->failIf($this->compareFileWithString());
    }

    /**
     * @return bool
     * @throws DidNotMatchException
     */
    protected function compareFileWithString()
    {
        // This will be replaced with:
        // https://github.com/elliotchance/concise/issues/290
        if (!file_exists($this->data[0])) {
            throw new DidNotMatchException(
                "File '{$this->data[0]}' does not exist."
            );
        }

        return $this->data[1] == file_get_contents($this->data[0]);
    }
}
