<?php

namespace Vados\MigrationRunner\Tests\command;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\Help;
use Vados\MigrationRunner\command\ICommand;

/**
 * Class HelpTest
 * @package Vados\MigrationRunner\Tests\command
 */
class HelpTest extends TestCase
{
    /**
     * @var Help
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Help();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ICommand::class, $this->instance);
    }

    public function testRun()
    {
        $result = <<<HELP
Available methods:
    - help - Show help information
    - create {name} - Create new migration
    - up {runCount=0} - Apply new migrations
    - down {runCount=1} - Revert some migration
HELP;
        $this->instance->run();
        $this->expectOutputString($result . PHP_EOL);
    }
}