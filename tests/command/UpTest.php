<?php

namespace Vados\MigrationRunner\Tests\command;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\ICommand;
use Vados\MigrationRunner\command\Up;
use Vados\MigrationRunner\Tests\proxy\Up as UpProxy;

/**
 * Class UpTest
 * @package Vados\MigrationRunner\Tests\command
 */
class UpTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testConstructorWithoutRunCount()
    {
        $instance = new Up([]);
        $this->assertInstanceOf(ICommand::class, $instance);
        $runCount = new \ReflectionProperty($instance, 'runCount');
        $runCount->setAccessible(true);
        $this->assertEquals(0, $runCount->getValue($instance));
    }

    /**
     * @throws \ReflectionException
     */
    public function testConstructorWithRunCount()
    {
        $instance = new Up([3]);
        $this->assertInstanceOf(ICommand::class, $instance);
        $runCount = new \ReflectionProperty($instance, 'runCount');
        $runCount->setAccessible(true);
        $this->assertEquals(3, $runCount->getValue($instance));
    }

    /**
     * @throws \ReflectionException
     */
    public function testUpMigrationDoesntExist()
    {
        $instance = new Up([]);
        $upMethod = new \ReflectionMethod($instance, 'up');
        $upMethod->setAccessible(true);
        $this->assertFalse($upMethod->invokeArgs($instance, ['not_exist']));
    }

    public function testGetMigrationList()
    {
        $instance = new UpProxy([]);
        $list = $instance->runGetMigrationList();
        $this->assertIsArray($list);
    }
}