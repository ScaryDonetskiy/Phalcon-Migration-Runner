<?php

namespace Vados\MigrationRunner\models;

use Phalcon\Mvc\Model;

/**
 * Class TblMigration
 * @package Vados\MigrationRunner\models
 */
class TblMigration extends Model
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $migration;

    /**
     * @return string
     */
    public function getMigration(): string
    {
        return $this->migration;
    }

    /**
     * @param string $migration
     */
    public function setMigration(string $migration)
    {
        $this->migration = $migration;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}