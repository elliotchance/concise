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
}
