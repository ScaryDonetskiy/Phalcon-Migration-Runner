<?php

namespace Vados\MigrationRunner\Tests\command;

use Phalcon\Db\AdapterInterface;
use Phalcon\Di;
use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\MigrationRun;
use Vados\MigrationRunner\command\Up;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class MigrationRunTest
 * @package Vados\MigrationRunner\Tests\command
 */
class MigrationRunTest extends TestCase
{
    /**
     * @var MigrationRun
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Up([]);
    }

    /**
     * @throws \ReflectionException
     */
    public function testActionConfirmation()
    {
        $actionConfirmation = new \ReflectionMethod($this->instance, 'actionConfirmation');
        $actionConfirmation->setAccessible(true);
        $actionConfirmation->invokeArgs($this->instance, ['some text']);
        $this->expectOutputString('some text (yes|no) [yes]: ');
    }

    /**
     * @throws \ReflectionException
     */
    public function testGetNewMigrations()
    {
        /**
         * Existing migrations
         */
        if (!is_dir(PathProvider::getMigrationDir())) {
            mkdir(PathProvider::getMigrationDir());
        }
        file_put_contents(PathProvider::getMigrationDir() . '/migration.php', '');
        $getExistingMigrations = new \ReflectionMethod($this->instance, 'getExistingMigrations');
        $getExistingMigrations->setAccessible(true);
        $result = $getExistingMigrations->invoke($this->instance);
        $this->assertInternalType('array', $result);
        $this->assertContains('migration.php', $result);
        /**
         * Applied migrations
         */
        $tbl = new TblMigration();
        $tbl->setMigration('some_migration');
        $tbl->save();
        $getAppliedMigrations = new \ReflectionMethod($this->instance, 'getAppliedMigrations');
        $getAppliedMigrations->setAccessible(true);
        $result = $getAppliedMigrations->invoke($this->instance);
        $this->assertInternalType('array', $result);
        $this->assertContains('some_migration', $result);
        /**
         * New migrations
         */
        $getNewMigrations = new \ReflectionMethod($this->instance, 'getNewMigrations');
        $getNewMigrations->setAccessible(true);
        $result = $getNewMigrations->invoke($this->instance);
        $this->assertInternalType('array', $result);
        $this->assertContains('migration.php', $result);
    }

    public function tearDown()
    {
        /** @var AdapterInterface $dbConnection */
        $dbConnection = Di::getDefault()->getShared('db');
        $dbConnection->dropTable('tbl_migration');
        if (file_exists(PathProvider::getMigrationDir() . '/migration.php')) {
            unlink(PathProvider::getMigrationDir() . '/migration.php');
        }
        if (is_dir(PathProvider::getMigrationDir())) {
            rmdir(PathProvider::getMigrationDir());
        }
    }
}