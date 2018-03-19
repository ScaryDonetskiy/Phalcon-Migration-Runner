<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 14:45
 */

namespace Vados\MigrationRunner\command;

use Phalcon\Db\AdapterInterface;
use Phalcon\Db\Column;
use Vados\MigrationRunner\enum\TableName;
use Vados\MigrationRunner\migration\DbSingleton;

/**
 * Class MigrationRun
 * @package Vados\MigrationRunner\command
 */
abstract class MigrationRun
{
    /**
     * @var AdapterInterface
     */
    private $dbInstance;

    /**
     * MigrationRun constructor.
     */
    protected function __construct()
    {
        $this->dbInstance = DbSingleton::getInstance();
        $this->checkMigrationTable();
    }

    protected function checkMigrationTable()
    {
        if (!$this->dbInstance->tableExists(TableName::TBL_MIGRATION)) {
            $this->dbInstance->createTable(TableName::TBL_MIGRATION, null, [
                'columns' => [
                    new Column('migration', [
                        'type' => Column::TYPE_TEXT,
                        'primary' => true
                    ])
                ]
            ]);
        }
    }

    protected function getAppliedMigrations()
    {
        $this->dbInstance->query("SELECT migration FROM {TableName::TBL_MIGRATION}");
    }
}