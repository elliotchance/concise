<?php

namespace Concise\Core;

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
        $vendor = $this->findVendorFolder();
        if (null === $vendor) {
            return '';
        }

        $packages =
            json_decode(file_get_contents("$vendor/composer/installed.json"));
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
            1 => array(
                'Big Bang',
                'Dark Matter',
                'String Theory',
                'Supernova',
                'Quantum',
                'Antimatter',
                'Entropy',
                'Multiverse',
            ),
            2 => array(
                'Ultraviolet',
                'Photon',
            )
        );

        $version = ltrim($version, 'v');
        if (strlen($version) < 3) {
            return '';
        }

        $major = substr($version, 0, 1);
        $minor = substr($version, 2, 1);

        if (isset($names[$major]) && isset($names[$major][$minor])) {
            return $names[$major][$minor];
        }
        else {
            return '';
        }
    }
}
