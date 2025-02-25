<?php

namespace App\utils;

class VersionComparator {
    /*public static function isOldVersion($version) {
        return version_compare($version, '1.0.17+60', '<=');
    }*/

    public static function isOldVersion($version) {
        $currentVersion = '1.0.17+60';

        $versionParts = self::splitVersion($version);
        $currentParts = self::splitVersion($currentVersion);

        foreach ($versionParts as $index => $part) {
            if (!isset($currentParts[$index])) {
                return false;
            }
            if ((int) $part < (int) $currentParts[$index]) {
                return true;
            } elseif ((int) $part > (int) $currentParts[$index]) {
                return false;
            }
        }

        return true;
    }

    private static function splitVersion($version) {
        return preg_split('/[.+]/', $version);
    }
}
