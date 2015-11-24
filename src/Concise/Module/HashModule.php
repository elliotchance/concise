<?php

namespace Concise\Module;

class HashModule extends AbstractModule
{
    public function getName()
    {
        return "Hashing (Cryptography)";
    }

    /**
     * Assert hash is an 8 digit hexadecimal.
     *
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
     * Assert hash is not an 8 digit hexadecimal.
     *
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
     * Assert hash is a 16 digit hexadecimal.
     *
     * @syntax hash ? is a valid fnv164
     */
    public function hash64()
    {
        $this->validateHexWithLength(16);
    }

    /**
     * Assert hash is not a 16 digit hexadecimal.
     *
     * @syntax hash ? is not a valid fnv164
     */
    public function hash64not()
    {
        $this->validateHexWithLength(16, false);
    }

    /**
     * Assert hash is a 32 digit hexadecimal.
     *
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
     * Assert hash is not a 32 digit hexadecimal.
     *
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
     * Assert hash is a 40 digit hexadecimal.
     *
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
     * Assert hash is not a 40 digit hexadecimal.
     *
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
     * Assert hash is a 48 digit hexadecimal.
     *
     * @syntax hash ? is a valid tiger192
     * @syntax hash ? is a valid haval192
     */
    public function hash192()
    {
        $this->validateHexWithLength(48);
    }

    /**
     * Assert hash is not a 48 digit hexadecimal.
     *
     * @syntax hash ? is not a valid tiger192
     * @syntax hash ? is not a valid haval192
     */
    public function hash192not()
    {
        $this->validateHexWithLength(48, false);
    }

    /**
     * Assert hash is a 56 digit hexadecimal.
     *
     * @syntax hash ? is a valid sha224
     * @syntax hash ? is a valid haval224
     */
    public function hash224()
    {
        $this->validateHexWithLength(56);
    }

    /**
     * Assert hash is not a 56 digit hexadecimal.
     *
     * @syntax hash ? is not a valid sha224
     * @syntax hash ? is not a valid haval224
     */
    public function hash224not()
    {
        $this->validateHexWithLength(56, false);
    }

    /**
     * Assert hash is a 64 digit hexadecimal.
     *
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
     * Assert hash is not a 64 digit hexadecimal.
     *
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
     * Assert hash is an 80 digit hexadecimal.
     *
     * @syntax hash ? is a valid ripemd320
     */
    public function hash320()
    {
        $this->validateHexWithLength(80);
    }

    /**
     * Assert hash is not a 80 digit hexadecimal.
     *
     * @syntax hash ? is not a valid ripemd320
     */
    public function hash320not()
    {
        $this->validateHexWithLength(80, false);
    }

    /**
     * Assert hash is a 96 digit hexadecimal.
     *
     * @syntax hash ? is a valid sha384
     */
    public function hash384()
    {
        $this->validateHexWithLength(96);
    }

    /**
     * Assert hash is not a 96 digit hexadecimal.
     *
     * @syntax hash ? is not a valid sha384
     */
    public function hash384not()
    {
        $this->validateHexWithLength(96, false);
    }

    /**
     * Assert hash is a 128 digit hexadecimal.
     *
     * @syntax hash ? is a valid sha512
     * @syntax hash ? is a valid whirlpool
     * @syntax hash ? is a valid salsa10
     * @syntax hash ? is a valid salsa20
     */
    public function hash512()
    {
        $this->validateHexWithLength(128);
    }

    /**
     * Assert hash is not a 128 digit hexadecimal.
     *
     * @syntax hash ? is not a valid sha512
     * @syntax hash ? is not a valid whirlpool
     * @syntax hash ? is not a valid salsa10
     * @syntax hash ? is not a valid salsa20
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
