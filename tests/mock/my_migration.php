<?php

use Vados\MigrationRunner\migration\Migration;

/**
 * Class my_migration
 */
class my_migration extends Migration
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