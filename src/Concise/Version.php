<?php

namespace Concise;

class Version
{
    public function findVendorFolder()
    {
        $path = __DIR__;
        for ($i = 0; $i < 10; ++$i) {
            $dir = scandir($path);
            if (in_array('vendor', $dir)) {
                return "$path/vendor";
            }
            $path .= "/..";
        }

        return null;
    }

    public function getVersionForPackage($packageName)
    {
        $vendor = $this->findVendorFolder(__DIR__);
        $packages = json_decode(file_get_contents("$vendor/composer/installed.json"));
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
