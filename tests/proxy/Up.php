<?php

namespace Vados\MigrationRunner\Tests\proxy;

/**
 * Class UpTest
 * @package Vados\MigrationRunner\Tests\proxy
 */
class Up extends \Vados\MigrationRunner\command\Up
{
    public function runGetMigrationList(): array
    {
        return $this->getMigrationsList();
    }
}