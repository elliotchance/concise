<?php

namespace Concise\Module;

class HashModule extends AbstractModule
{
    public function getName()
    {
        return "Hash";
    }

    /**
     * @syntax hash ? is a valid crc32
     * @syntax hash ? is a valid crc32b
     * @syntax hash ? is a valid adler32
     * @syntax hash ? is a valid fnv132
     * @syntax hash ? is a valid joaat
     */
    public function hash32()
    {
        $this->validateHexWithLength(8);
    }

    /**
     * @syntax hash ? is a valid fnv164
     */
    public function hash64()
    {
        $this->validateHexWithLength(16);
    }

    /**
     * @syntax hash ? is a valid md5
     * @syntax hash ? is a valid md4
     * @syntax hash ? is a valid md2
     * @syntax hash ? is a valid ripemd128
     * @syntax hash ? is a valid tiger128
     * @syntax hash ? is a valid haval128
     */
    public function hash128()
    {
        $this->validateHexWithLength(32);
    }

    /**
     * @syntax hash ? is a valid sha1
     * @syntax hash ? is a valid ripemd160
     * @syntax hash ? is a valid tiger160
     * @syntax hash ? is a valid haval160
     */
    public function hash160()
    {
        $this->validateHexWithLength(40);
    }

    /**
     * @syntax hash ? is a valid tiger192
     * @syntax hash ? is a valid haval192
     */
    public function hash192()
    {
        $this->validateHexWithLength(48);
    }

    /**
     * @syntax hash ? is a valid sha224
     * @syntax hash ? is a valid haval224
     */
    public function hash224()
    {
        $this->validateHexWithLength(56);
    }

    /**
     * @syntax hash ? is a valid sha256
     * @syntax hash ? is a valid ripemd256
     * @syntax hash ? is a valid haval256
     * @syntax hash ? is a valid snefru
     * @syntax hash ? is a valid snefru256
     * @syntax hash ? is a valid gost
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
