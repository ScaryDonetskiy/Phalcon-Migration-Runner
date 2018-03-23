<?php

namespace Vados\MigrationRunner\Tests\mock;

use Vados\MigrationRunner\migration\Migration;

/**
 * Class MigrationExceptionMock
 * @package Vados\MigrationRunner\Tests\mock
 */
class MigrationExceptionMock extends Migration
{

    /**
     * @return bool
     * @throws \Exception
     */
    public function up(): bool
    {
        throw new \Exception('Error');
    }

    /**
     * @return bool
     */
    public function down(): bool
    {
        // TODO: Implement down() method.
    }
}