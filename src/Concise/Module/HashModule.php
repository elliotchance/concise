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
    }
}
