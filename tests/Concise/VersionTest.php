<?php

namespace Concise;

class VersionTest extends TestCase
{
    public function testAnEmptyStringWillBeReturnedIfThePackageCanNotBeFound()
    {
        $version = new Version();
        $this->assert($version->getVersionForPackage('foo'), is_blank);
    }

    public function testVersionCanBeExtractedForAPackageName()
    {
        $version = new Version();
        $this->assert($version->getVersionForPackage('sebastian/version'), matches_regex, '/^\\d\.\\d+/');
    }
}
