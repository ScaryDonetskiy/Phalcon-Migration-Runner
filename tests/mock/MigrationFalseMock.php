<?php

namespace Vados\MigrationRunner\Tests\mock;

use Vados\MigrationRunner\migration\Migration;

/**
 * Class MigrationFalseMock
 * @package Vados\MigrationRunner\Tests\mock
 */
class MigrationFalseMock extends Migration
{

    /**
     * @return bool
     */
    public function up(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function down(): bool
    {
        return false;
    }
}