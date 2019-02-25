<?php

namespace Vados\MigrationRunner\Tests;

use PHPUnit\Framework\TestCase;
use Vados\MigrationRunner\Helpers;

/**
 * Class HelpersTest
 * @package Vados\MigrationRunner\Tests
 */
class HelpersTest extends TestCase
{
    public function testBoolToStringTrue()
    {
        $result = Helpers::boolToString(true);
        $this->assertIsString($result);
        $this->assertEquals('true', $result);
    }

    public function testBoolToStringFalse()
    {
        $result = Helpers::boolToString(false);
        $this->assertIsString($result);
        $this->assertEquals('false', $result);
    }
}