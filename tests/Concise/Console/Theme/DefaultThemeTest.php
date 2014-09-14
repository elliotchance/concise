<?php

namespace Concise\Console\Theme;

use Concise\TestCase;
use PHPUnit_Runner_BaseTestRunner;

class DefaultThemeTest extends TestCase
{
    protected $theme;

    public function setUp()
    {
        parent::setUp();
        $this->theme = new DefaultTheme();
    }

    public function keysProvider()
    {
        return array(
            array(PHPUnit_Runner_BaseTestRunner::STATUS_PASSED),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_FAILURE),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_ERROR),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_SKIPPED),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_INCOMPLETE),
            array(PHPUnit_Runner_BaseTestRunner::STATUS_RISKY),
            array('value.integer'),
            array('value.float'),
            array('value.string'),
            array('value.closure'),
        );
    }

    /**
     * @dataProvider keysProvider
     */
    public function testThemeHasSuccess($expectedKey)
    {
        $this->assert($this->theme->getTheme(), has_key, $expectedKey);
    }
}
