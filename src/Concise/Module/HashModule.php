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
     * @syntax hash ? is an ripemd128
     */
    public function hash128()
    {
        $this->validateHexWithLength(32);
    }

    /**
     * @syntax hash ? is an sha1
     * @syntax hash ? is an ripemd160
     */
    public function hash160()
    {
        $this->validateHexWithLength(40);
    }

    /**
     * @syntax hash ? is an sha224
     */
    public function hash224()
    {
        $this->validateHexWithLength(56);
    }

    /**
     * @syntax hash ? is an sha256
     * @syntax hash ? is an ripemd256
     */
    public function hash256()
    {
        $this->validateHexWithLength(64);
    }

    /**
     * @syntax hash ? is an ripemd320
     */
    public function hash320()
    {
        $this->validateHexWithLength(80);
    }

    /**
     * @syntax hash ? is an sha384
     */
    public function hash384()
    {
        $this->validateHexWithLength(96);
    }

    /**
     * @syntax hash ? is an sha512
     * @syntax hash ? is an whirlpool
     */
    public function hash512()
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
