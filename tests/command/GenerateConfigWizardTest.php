<?php

namespace Vados\MigrationRunner\Tests\command;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\command\GenerateConfigWizard;
use Vados\MigrationRunner\command\ICommand;

/**
 * Class GenerateConfigWizardTest
 * @package Vados\MigrationRunner\Tests\command
 */
class GenerateConfigWizardTest extends TestCase
{
    /**
     * @var GenerateConfigWizard
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new GenerateConfigWizard();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf(ICommand::class, $this->instance);
    }
}