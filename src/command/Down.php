<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 22.03.2018
 * Time: 20:03
 */

namespace Vados\MigrationRunner\command;
use Vados\MigrationRunner\migration\Migration;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

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
    private $runCount;

    /**
     * Down constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        parent::__construct();
        $this->params = $params;
        $this->runCount = (int)$params[0];
        if ($this->runCount) {
            $this->runCount = 1;
        }
    }

    public function run()
    {
        $migrations = TblMigration::find([
            'order' => 'id DESC',
            'limit' => $this->runCount
        ]);
        if ($migrations) {
            foreach ($migrations as $migration) {
                /** @var TblMigration $migration */
                echo $migration->getMigration() . PHP_EOL;
            }
            if ($this->actionConfirmation('Revert the above migrations?')) {
                foreach ($migrations as $migration) {
                    echo "Migration $migration: ";
                    $result = $this->down($migration);
                    echo $result ? 'true' : 'false';
                    echo PHP_EOL;
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