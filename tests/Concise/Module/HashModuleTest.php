<?php

namespace Concise\Module;

/**
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

    public function testValidMd5()
    {
        $this->assertHash(md5('a'))->isAnMd5;
    }

    public function testMd5IsLessThan32Characters()
    {
        $this->expectFailure('hash "123" is an md5');
        $this->assertHash('123')->isAnMd5;
    }

    public function testMd5IsGreatherThan32Characters()
    {
        $hash = str_repeat('a', 34);
        $this->expectFailure("hash \"$hash\" is an md5");
        $this->assertHash($hash)->isAnMd5;
    }
}
