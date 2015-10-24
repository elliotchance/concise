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
     * @syntax hash ? is an md4
     * @syntax hash ? is an md2
     */
    public function isAnMd245()
    {
        $this->validateHexWithLength(32);
    }

    /**
     * @syntax hash ? is an sha1
     */
    public function isAnSha1()
    {
        $this->validateHexWithLength(40);
    }

    /**
     * @syntax hash ? is an sha224
     */
    public function isAnSha224()
    {
        $this->validateHexWithLength(56);
    }

    /**
     * @syntax hash ? is an sha256
     */
    public function isAnSha256()
    {
        $this->validateHexWithLength(64);
    }

    /**
     * @syntax hash ? is an sha384
     */
    public function isAnSha384()
    {
        $this->validateHexWithLength(96);
    }

    /**
     * @syntax hash ? is an sha512
     */
    public function isAnSha512()
    {
        $this->validateHexWithLength(128);
    }

    protected function validateHexWithLength($length)
    {
        $this->failIf(
            !preg_match("/^[a-f0-9]{" . $length . "}$/i", $this->data[0])
        );
    }
}
