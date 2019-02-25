<?php

namespace Vados\MigrationRunner\command;

use Phalcon\Db\AdapterInterface;
use Phalcon\Db\Column;
use Phalcon\Di;
use Vados\MigrationRunner\enum\TableName;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

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
        $this->dbInstance = Di::getDefault()->getShared('db');
        $this->checkMigrationTable();
    }

    protected function checkMigrationTable()
    {
        if (!$this->dbInstance->tableExists(TableName::TBL_MIGRATION)) {
            $this->dbInstance->createTable(TableName::TBL_MIGRATION, null, [
                'columns' => [
                    new Column('id', [
                        'type' => Column::TYPE_INTEGER,
                        'primary' => true
                    ]),
                    new Column('migration', [
                        'type' => Column::TYPE_TEXT
                    ])
                ]
            ]);
        }
    }

    /**
     * @return array
     */
    protected function getAppliedMigrations(): array
    {
        $migrations = [];
        foreach (TblMigration::find() as $item) {
            /** @var TblMigration $item */
            $migrations[] = $item->getMigration();
        }
        return $migrations;
    }

    /**
     * @return array
     */
    protected function getExistingMigrations(): array
    {
        if (!is_dir(PathProvider::getMigrationDir())) {
            return [];
        }
        $migrations = scandir(PathProvider::getMigrationDir());
        $ignore = ['.', '..'];
        return array_filter($migrations, function($item) use ($ignore) {
            return !in_array($item, $ignore);
        });
    }

    /**
     * @return array
     */
    protected function getNewMigrations(): array
    {
        $migrations = array_diff($this->getExistingMigrations(), $this->getAppliedMigrations());
        sort($migrations);
        return $migrations;
    }

    /**
     * @param string $text
     * @return bool
     */
    protected function actionConfirmation(string $text): bool
    {
        echo "$text (yes|no) [yes]: ";
        $answer = trim(fgets(STDIN));
        if (!$answer) {
            $answer = 'yes';
        }
        return !strncasecmp($answer, 'y', 1);
    }
}