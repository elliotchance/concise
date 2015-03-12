<?php

namespace Concise;

class Version
{
    /**
     * @param string $path
     * @return null|string
     */
    public function findVendorFolder($path = null)
    {
        if (null === $path) {
            $path = __DIR__;
        }
        for ($i = 0; $i < 10; ++$i) {
            $dir = scandir($path);
            if (in_array('vendor', $dir)) {
                return "$path/vendor";
            }
            $path .= "/..";
        }

        return null;
    }

    /**
     * @param string $packageName
     * @return string
     */
    public function getVersionForPackage($packageName)
    {
        $vendor = $this->findVendorFolder(__DIR__);
        if (!$vendor) {
            return '';
        }

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

    public function getVersionNameForVersion($version)
    {
        $names = array(
            'Big Bang',
            'Dark Matter',
            'String Theory',
            'Supernova',
            'Quantum',
            'Antimatter',
            'Entropy',
            'Multiverse',
        );

        $version = ltrim($version, 'v');
        if (strlen($version) < 3) {
            return '';
        }

        return $names[substr($version, 2, 1)];
    }
}
