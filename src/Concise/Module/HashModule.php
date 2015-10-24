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
        $this->failIf(!preg_match('/^[a-f0-9]{32}$/', $this->data[0]));
    }
}
