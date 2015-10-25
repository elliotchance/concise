<?php

namespace Concise\Module;

class HashModule extends AbstractModule
{
    public function getName()
    {
        return "Hashing (Cryptography)";
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
     * @syntax hash ? is not a valid crc32
     * @syntax hash ? is not a valid crc32b
     * @syntax hash ? is not a valid adler32
     * @syntax hash ? is not a valid fnv132
     * @syntax hash ? is not a valid joaat
     */
    public function hash32not()
    {
        $this->validateHexWithLength(8, false);
    }

    /**
     * @syntax hash ? is a valid fnv164
     */
    public function hash64()
    {
        $this->validateHexWithLength(16);
    }

    /**
     * @syntax hash ? is not a valid fnv164
     */
    public function hash64not()
    {
        $this->validateHexWithLength(16, false);
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
     * @syntax hash ? is not a valid md5
     * @syntax hash ? is not a valid md4
     * @syntax hash ? is not a valid md2
     * @syntax hash ? is not a valid ripemd128
     * @syntax hash ? is not a valid tiger128
     * @syntax hash ? is not a valid haval128
     */
    public function hash128not()
    {
        $this->validateHexWithLength(32, false);
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
     * @syntax hash ? is not a valid sha1
     * @syntax hash ? is not a valid ripemd160
     * @syntax hash ? is not a valid tiger160
     * @syntax hash ? is not a valid haval160
     */
    public function hash160not()
    {
        $this->validateHexWithLength(40, false);
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
     * @syntax hash ? is not a valid tiger192
     * @syntax hash ? is not a valid haval192
     */
    public function hash192not()
    {
        $this->validateHexWithLength(48, false);
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
     * @syntax hash ? is not a valid sha224
     * @syntax hash ? is not a valid haval224
     */
    public function hash224not()
    {
        $this->validateHexWithLength(56, false);
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
     * @syntax hash ? is not a valid sha256
     * @syntax hash ? is not a valid ripemd256
     * @syntax hash ? is not a valid haval256
     * @syntax hash ? is not a valid snefru
     * @syntax hash ? is not a valid snefru256
     * @syntax hash ? is not a valid gost
     */
    public function hash256not()
    {
        $this->validateHexWithLength(64, false);
    }

    /**
     * @syntax hash ? is a valid ripemd320
     */
    public function hash320()
    {
        $this->validateHexWithLength(80);
    }

    /**
     * @syntax hash ? is not a valid ripemd320
     */
    public function hash320not()
    {
        $this->validateHexWithLength(80, false);
    }

    /**
     * @syntax hash ? is a valid sha384
     */
    public function hash384()
    {
        $this->validateHexWithLength(96);
    }

    /**
     * @syntax hash ? is not a valid sha384
     */
    public function hash384not()
    {
        $this->validateHexWithLength(96, false);
    }

    /**
     * @syntax hash ? is a valid sha512
     * @syntax hash ? is a valid whirlpool
     */
    public function hash512()
    {
        $this->validateHexWithLength(128);
    }

    /**
     * @syntax hash ? is not a valid sha512
     * @syntax hash ? is not a valid whirlpool
     */
    public function hash512not()
    {
        $this->validateHexWithLength(128, false);
    }

    protected function validateHexWithLength($length, $inverse = true)
    {
        $match = preg_match("/^[a-f0-9]{" . $length . "}$/i", $this->data[0]);
        if ($inverse) {
            $match = !$match;
        }
        $this->failIf($match);
    }
}
