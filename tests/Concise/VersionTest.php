<?php

namespace Concise;

class VersionTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->version = new Version();
    }

    public function testAnEmptyStringWillBeReturnedIfThePackageCanNotBeFound()
    {
        $this->assert($this->version->getVersionForPackage('foo'), is_blank);
    }

    public function testVersionCanBeExtractedForAPackageName()
    {
        $this->assert(
            $this->version->getVersionForPackage('sebastian/version'),
            matches_regex,
            '/^\\d\.\\d+/'
        );
    }

    public function testWeCanEasilyGetTheConciseVersion()
    {
        $this->assert(
            $this->version->getConciseVersion(),
            equals,
            $this->version->getVersionForPackage('elliotchance/concise')
        );
    }

    public function testFindingVendorFolder()
    {
        $this->assert($this->version->findVendorFolder(), ends_with, '/vendor');
    }

    public function testReturnEmptyStringIfVendorFolderCannotBeFound()
    {
        $version = $this->niceMock('Concise\Version')
                        ->stub('findVendorFolder')
                        ->get();
        $this->assert($version->getConciseVersion(), is_blank);
    }

    public function testFindVendorFolderWillReturnNullIfTheVendorFolderCouldNotBeFound()
    {
        $version = $this->niceMock('Concise\Version')
                        ->expose('findVendorFolder')
                        ->get();
        $this->assert($version->findVendorFolder('/tmp'), is_null);
    }

    /**
     * @group #257
     */
    public function testVersionNameForUnknownVersionIsBlank()
    {
        $this->assert($this->version->getVersionNameForVersion(''), is_blank);
    }

    /**
     * @group #257
     */
    public function testVersionBigBang()
    {
        $name = $this->version->getVersionNameForVersion('v1.0');
        $this->assert($name, equals, 'Big Bang');
    }

    /**
     * @group #257
     */
    public function testVersionDoesNotHaveToIncludePrefixingVCharacter()
    {
        $name = $this->version->getVersionNameForVersion('1.0');
        $this->assert($name, equals, 'Big Bang');
    }

    /**
     * @group #257
     */
    public function testVersionDarkMatter()
    {
        $name = $this->version->getVersionNameForVersion('1.1');
        $this->assert($name, equals, 'Dark Matter');
    }
}
