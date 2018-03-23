<?php

namespace Vados\MigrationRunner\Tests\migration;

use Phalcon\Db\AdapterInterface;
use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\migration\Migration;
use Vados\MigrationRunner\Tests\mock\MigrationExceptionMock;
use Vados\MigrationRunner\Tests\mock\MigrationFalseMock;
use Vados\MigrationRunner\Tests\mock\MigrationMock;

/**
 * Class MigrationTest
 * @package Vados\MigrationRunner\Tests\migration
 */
class MigrationTest extends TestCase
{
    /**
     * @var Migration
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new MigrationMock();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(Migration::class, $this->instance);
    }

    public function testGetDbConnection()
    {
        $this->assertInstanceOf(AdapterInterface::class, $this->instance->getDbConnection());
    }

    public function testSafeRunUp()
    {
        $this->assertTrue($this->instance->safeRun('up'));
    }

    public function testSafeRunDown()
    {
        $this->assertTrue($this->instance->safeRun('down'));
    }

    public function testSafeRunFalseUp()
    {
        $this->instance = new MigrationFalseMock();
        $this->assertFalse($this->instance->safeRun('up'));
    }

    public function testSafeRunExceptionUp()
    {
        $this->instance = new MigrationExceptionMock();
        $this->assertFalse($this->instance->safeRun('up'));
        $this->expectOutputString('Error' . PHP_EOL);
    }
}