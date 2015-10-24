<?php

namespace Concise\Module;

class HashModule extends AbstractModule
{
    public function getName()
    {
        return "Hash";
    }

    /**
     * @syntax hash ? is a valid md5
     * @syntax hash ? is a valid md4
     * @syntax hash ? is a valid md2
     * @syntax hash ? is a valid ripemd128
     * @syntax hash ? is a valid tiger128
     */
    public function hash128()
    {
        $this->validateHexWithLength(32);
    }

    /**
     * @syntax hash ? is a valid sha1
     * @syntax hash ? is a valid ripemd160
     * @syntax hash ? is a valid tiger160
     */
    public function hash160()
    {
        $this->validateHexWithLength(40);
    }

    /**
     * @syntax hash ? is a valid tiger192
     */
    public function hash192()
    {
        $this->validateHexWithLength(48);
    }

    /**
     * @syntax hash ? is a valid sha224
     */
    public function hash224()
    {
        $this->validateHexWithLength(56);
    }

    /**
     * @syntax hash ? is a valid sha256
     * @syntax hash ? is a valid ripemd256
     */
    public function hash256()
    {
        $this->validateHexWithLength(64);
    }

    /**
     * @syntax hash ? is a valid ripemd320
     */
    public function hash320()
    {
        $this->validateHexWithLength(80);
    }

    /**
     * @syntax hash ? is a valid sha384
     */
    public function hash384()
    {
        $this->validateHexWithLength(96);
    }

    /**
     * @syntax hash ? is a valid sha512
     * @syntax hash ? is a valid whirlpool
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
