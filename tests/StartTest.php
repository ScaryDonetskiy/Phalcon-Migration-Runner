<?php

namespace Vados\MigrationRunner\Tests;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\Start;

/**
 * Class StartTest
 * @package Vados\MigrationRunner\Tests
 */
class StartTest extends TestCase
{
    /**
     * @var Start
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Start([]);
    }

    /**
     * @throws \ReflectionException
     */
    public function testDefaultCommand()
    {
        $command = new \ReflectionProperty($this->instance, 'command');
        $command->setAccessible(true);
        $this->assertEquals('help', $command->getValue($this->instance));
    }

    /**
     * @throws \ReflectionException
     */
    public function testSetCommand()
    {
        $this->instance = new Start([null, 'help']);
        $command = new \ReflectionProperty($this->instance, 'command');
        $command->setAccessible(true);
        $this->assertEquals('help', $command->getValue($this->instance));
    }
}