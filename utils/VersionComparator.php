<?php

class VersionComparator {
    public static function isOldVersion($version) {
        return version_compare($version, '1.0.17+60', '<=');
    }
}
