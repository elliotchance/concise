<?php

namespace Concise\Module;

class HashModule extends AbstractModule
{
    public function getName()
    {
        return "Hash";
    }

    /**
     * @syntax hash ? is an md5
     */
    public function isAnMd5()
    {
        $this->failIf(strlen($this->data[0]) != 32);
    }
}
