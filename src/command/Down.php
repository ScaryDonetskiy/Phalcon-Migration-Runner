<?php

namespace Vados\MigrationRunner\command;

use Vados\MigrationRunner\Helpers;
use Vados\MigrationRunner\migration\Migration;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;
use Phalcon\Mvc\Model\Resultset\Simple;

/**
 * Class Down
 * @package Vados\MigrationRunner\command
 */
class Down extends MigrationRun implements ICommand
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var int
     */
    private $runCount = 1;

    /**
     * Down constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        parent::__construct();
        $this->params = $params;
        if (isset($params[0])) {
            $this->runCount = (int)$params[0];
        }
    }

    public function run()
    {
        /** @var Simple $migrations */
        $migrations = TblMigration::find([
            'order' => 'id DESC',
            'limit' => $this->runCount
        ]);
        if ($migrations->count()) {
            foreach ($migrations as $migration) {
                /** @var TblMigration $migration */
                echo $migration->getMigration() . PHP_EOL;
            }
            if ($this->actionConfirmation('Revert the above migrations?')) {
                foreach ($migrations as $migration) {
                    /** @var TblMigration $migration */
                    echo "Migration {$migration->getMigration()}: ";
                    $result = $this->down($migration);
                    echo Helpers::boolToString($result) . PHP_EOL;
                    if (!$result) {
                        break;
                    }
                }
            }
        }
    }

    /**
     * @param TblMigration $migration
     * @return bool
     */
    private function down(TblMigration $migration): bool
    {
        if (file_exists(PathProvider::getMigrationDir() . DIRECTORY_SEPARATOR . $migration->getMigration())) {
            require_once PathProvider::getMigrationDir() . DIRECTORY_SEPARATOR . $migration->getMigration();
            $migrationClass = substr($migration->getMigration(), 0, -4);
            /** @var Migration $m */
            $m = new $migrationClass();
            if ($m->safeRun('down')) {
                $migration->delete();
                return true;
            }
        }
        return false;
    }
}