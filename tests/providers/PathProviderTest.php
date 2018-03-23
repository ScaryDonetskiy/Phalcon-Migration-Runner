<?php

namespace Vados\MigrationRunner\Tests\providers;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class PathProviderTest
 * @package Vados\MigrationRunner\Tests\providers
 */
class PathProviderTest extends TestCase
{
    public function testGetMigrationDir()
    {
        $this->assertEquals(getcwd() . '/migrations', PathProvider::getMigrationDir());
    }

    public function testGetConfig()
    {
        $this->assertEquals(getcwd() . '/migration_runner.config.php', PathProvider::getConfig());
    }
}