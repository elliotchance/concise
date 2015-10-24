<?php

namespace Concise\Module;

/**
 * Testing hashes is quite easy. We want to select values, that when hashed will
 * result in all the possible characters (16 for hexadecimal) in the one hash.
 *
 * Included is a function that generates these values
 *
 * @group matcher
 * @group #269
 */
class HashModuleTest extends AbstractModuleTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->module = new HashModule();
    }

    public function _testGenerateValues()
    {
        foreach (hash_algos() as $algorithm) {
            $found = false;

            // Limit it so we know to give up at an acceptable point.
            for ($i = 0; $i < 10000; ++$i) {
                $v = rand();
                $hash = hash($algorithm, $v);
                $cs = array();
                foreach (str_split($hash) as $c) {
                    $cs[$c] = true;
                }
                if (count($cs) == 16) {
                    echo "$algorithm('$v') = $hash\n";
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                echo "$algorithm ws not found, lets use $algorithm('$v') = $hash\n";
            }
        }
        exit;
    }

    public function data()
    {
        $tests = array();
        $data = array(
            'md2' => '644737658',
            'md4' => '76041011',
            'md5' => '765747394',

            'sha1' => '2121945217',
            'sha224' => '1992137930',
            'sha256' => '1409763972',
            'sha384' => '923831157',
            'sha512' => '2009834756',

            'ripemd128' => '1700793405',
            'ripemd160' => '115914122',
            'ripemd256' => '2043415493',
            'ripemd320' => '192604904',

            'whirlpool' => '27326413',

            'tiger128,3' => '2090191574',
            'tiger160,3' => '1473588334',
            'tiger192,3' => '1052121460',
            'tiger128,4' => '1325565485',
            'tiger160,4' => '195633033',
            'tiger192,4' => '1129380416',

            'haval128,3' => '1874865090',
            'haval160,3' => '665890248',
            'haval192,3' => '1290127780',
            'haval224,3' => '1967643772',
            'haval256,3' => '1567640248',
            'haval128,4' => '88762273',
            'haval160,4' => '1044306765',
            'haval192,4' => '1987085131',
            'haval224,4' => '1474207093',
            'haval256,4' => '453892265',
            'haval128,5' => '1129800014',
            'haval160,5' => '1562869785',
            'haval192,5' => '1209126060',
            'haval224,5' => '1910603999',
            'haval256,5' => '827858962',

//            'snefru('2053211574') = de7877c2898ab807a6d1ffac3a104ffeda655b7d96c9e62a29fcf5872472d537
//            'snefru256('2050122072') = 935a0b4c687610a714425ee2f296a64c22bbe12dd5eaf0fb8030302c7ea4dd68
//            'gost('791752798') = e605b24b7c9696d1e64db10bcdd14c02b2b9489a4728de7af886692be0ce325b
//            'adler32 ws not found, lets use adler32('289014769') = 094901df
//            'crc32 ws not found, lets use crc32('2070072372') = 33ebaf92
//            'crc32b ws not found, lets use crc32b('1157365562') = f509441c
//            'fnv132 ws not found, lets use fnv132('1312987169') = 6b743798
//            'fnv164 ws not found, lets use fnv164('1920646076') = f72f9bc4c663fe6e
//            'joaat ws not found, lets use joaat('1388690451') = f0f10e82
        );
        foreach ($data as $algorithm => $value) {
            $raw = explode(',', $algorithm);
            $a = ucfirst($raw[0]);

            // passes
            $v = hash($algorithm, $value);
            $tests["$algorithm lower"] = array("isAValid$a", $v);
            $tests["$algorithm upper"] = array("isAValid$a", strtoupper($v));

            // failures
            $tests["$algorithm too short"] = array(
                "isAValid$a",
                '0',
                "hash \"0\" is a valid $raw[0]"
            );
            $tests["$algorithm too long"] = array(
                "isAValid$a",
                "0$v",
                "hash \"0$v\" is a valid $raw[0]"
            );
            $tests["$algorithm bad character"] = array(
                "isAValid$a",
                "z" . substr($v, 1),
                "hash \"z" . substr($v, 1) . "\" is a valid $raw[0]"
            );
        }

        return $tests;
    }

    /**
     * @dataProvider data
     */
    public function testHash($hash, $value, $error = null)
    {
        if ($error) {
            $this->expectFailure($error);
        }
        $this->assertHash($value)->$hash;
    }
}
