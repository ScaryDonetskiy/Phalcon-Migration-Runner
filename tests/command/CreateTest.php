<?php

namespace Vados\MigrationRunner\Tests\command;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\Create;
use Vados\MigrationRunner\command\ICommand;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class CreateTest
 * @package Vados\MigrationRunner\Tests\command
 */
class CreateTest extends TestCase
{
    public function testConstructorWithoutMigrationName()
    {
        $instance = new Create([]);
        $this->assertInstanceOf(ICommand::class, $instance);
    }

    /**
     * @throws \ReflectionException
     */
    public function testConstructorWithMigrationName()
    {
        $instance = new Create(['my_migration']);
        $this->assertInstanceOf(ICommand::class, $instance);
        $migrationName = new \ReflectionProperty($instance, 'migrationName');
        $migrationName->setAccessible(true);
        $this->assertEquals($migrationName->getValue($instance), 'my_migration');
    }

    public function testRun()
    {
        $instance = new Create(['my_migration']);
        if (is_dir(PathProvider::getMigrationDir())) {
            $this->rmDirRecursive(PathProvider::getMigrationDir());
        }
        $instance->run();
        $migrationName = 'm' . time() . '_my_migration.php';
        $this->expectOutputString('Migration ' . PathProvider::getMigrationDir() . '/' . $migrationName . ' created!' . PHP_EOL);
        $this->assertDirectoryExists(PathProvider::getMigrationDir());
        $this->assertFileExists(PathProvider::getMigrationDir() . "/$migrationName");
    }

    private function rmDirRecursive(string $dir): bool
    {
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $fullPath = "$dir/$file";
            (is_dir($fullPath)) ? $this->rmDirRecursive($fullPath) : unlink($fullPath);
        }
        return rmdir($dir);
    }

    public function tearDown()
    {
        if (is_dir(PathProvider::getMigrationDir())) {
            $this->rmDirRecursive(PathProvider::getMigrationDir());
        }
    }
}