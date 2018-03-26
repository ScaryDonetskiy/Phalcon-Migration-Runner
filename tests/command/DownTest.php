<?php

namespace Vados\MigrationRunner\Tests\command;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\Down;
use Vados\MigrationRunner\command\ICommand;
use Vados\MigrationRunner\models\TblMigration;

/**
 * Class DownTest
 * @package Vados\MigrationRunner\Tests\command
 */
class DownTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testConstructorWithoutRunCount()
    {
        $instance = new Down([]);
        $this->assertInstanceOf(ICommand::class, $instance);
        $runCount = new \ReflectionProperty($instance, 'runCount');
        $runCount->setAccessible(true);
        $this->assertEquals(1, $runCount->getValue($instance));
    }

    /**
     * @throws \ReflectionException
     */
    public function testConstructorWithRunCount()
    {
        $instance = new Down([3]);
        $this->assertInstanceOf(ICommand::class, $instance);
        $runCount = new \ReflectionProperty($instance, 'runCount');
        $runCount->setAccessible(true);
        $this->assertEquals(3, $runCount->getValue($instance));
    }

    /**
     * @throws \ReflectionException
     */
    public function testDownMigrationDoesntExist()
    {
        $instance = new Down([]);
        $tbl = new TblMigration();
        $tbl->setMigration('not_exist');
        $downMethod = new \ReflectionMethod($instance, 'down');
        $downMethod->setAccessible(true);
        $this->assertFalse($downMethod->invokeArgs($instance, [$tbl]));
    }
}