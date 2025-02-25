<?php

use App\utils\VersionComparator;
use PHPUnit\Framework\TestCase;

class VersionComparatorTest extends TestCase
{
    public function testIsOldVersion()
    {
        //$this->assertTrue(VersionComparator::isOldVersion('1.0.17+59'));
        //$this->assertTrue(VersionComparator::isOldVersion('1.0.17+60'));
        //$this->assertFalse(VersionComparator::isOldVersion('1.0.17+61'));
        $this->assertFalse(VersionComparator::isOldVersion('1.1.0'));
    }
}