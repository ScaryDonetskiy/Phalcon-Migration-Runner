<?php

namespace Vados\MigrationRunner\Tests\mock;

use Vados\MigrationRunner\migration\Migration;

/**
 * Class MigrationMock
 * @package Vados\MigrationRunner\Tests\mock
 */
class MigrationMock extends Migration
{

    /**
     * @return bool
     */
    public function up(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function down(): bool
    {
        return true;
    }
}