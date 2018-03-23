<?php

namespace Vados\MigrationRunner\Tests\command;

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\Down;
use Vados\MigrationRunner\command\Up;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class MigrationFlowTest
 * @package Vados\MigrationRunner\Tests\command
 */
class MigrationFlowTest extends TestCase
{
    const DBNAME = 'test.db';

    /**
     * @throws \ReflectionException
     */
    public function testFlow()
    {
        $this->clear();
        $this->prepareConfig();
        $this->setDi();
        $this->copyMigration();
        $this->upMigration();
        $this->downMigration();
        $this->clear();
    }

    private function prepareConfig()
    {
        file_put_contents(PathProvider::getConfig(), '<?php return ' . var_export([
                'adapter' => 'sqlite',
                'dbname' => self::DBNAME
            ], true) . ';');
    }

    private function setDi()
    {
        Di::reset();
        $di = new Di();
        $di->setShared('db', function () {
            return Factory::load(require PathProvider::getConfig());
        });
        $di->set('modelsManager', new Manager());
        $di->set('modelsMetadata', new Memory());
    }

    private function copyMigration()
    {
        if (is_dir(PathProvider::getMigrationDir())) {
            $this->rmDirRecursive(PathProvider::getMigrationDir());
        }
        mkdir(PathProvider::getMigrationDir());
        copy(getcwd() . '/tests/mock/my_migration.php', PathProvider::getMigrationDir() . '/my_migration.php');
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

    /**
     * @throws \ReflectionException
     */
    private function upMigration()
    {
        $instance = new Up([]);
        $upMethod = new \ReflectionMethod($instance, 'up');
        $upMethod->setAccessible(true);
        $this->assertTrue($upMethod->invokeArgs($instance, ['my_migration.php']));
    }

    /**
     * @throws \ReflectionException
     */
    private function downMigration()
    {
        $instance = new Down([]);
        $upMethod = new \ReflectionMethod($instance, 'down');
        $upMethod->setAccessible(true);
        $migration = new TblMigration();
        $migration->setMigration('my_migration.php');
        $this->assertTrue($upMethod->invokeArgs($instance, [$migration]));
    }

    private function clear()
    {
        if (is_dir(PathProvider::getMigrationDir())) {
            $this->rmDirRecursive(PathProvider::getMigrationDir());
        }
        if (file_exists(PathProvider::getConfig())) {
            unlink(PathProvider::getConfig());
        }
        if (file_exists(getcwd() . '/' . self::DBNAME)) {
            unlink(getcwd() . '/' . self::DBNAME);
        }
    }
}