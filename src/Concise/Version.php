<?php

namespace Concise;

class Version
{
    public function getVersionForPackage($packageName)
    {
        $packages = json_decode(file_get_contents(__DIR__ . '/../../vendor/composer/installed.json'));
        foreach ($packages as $package) {
            if ($package->name === $packageName) {
                return $package->version;
            }
        }

        return '';
    }

    public function getConciseVersion()
    {
        return $this->getVersionForPackage('elliotchance/concise');
    }
}
