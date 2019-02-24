<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 13:39
 */

namespace Vados\MigrationRunner\command;
use Vados\MigrationRunner\migration\Migration;
use Vados\MigrationRunner\models\TblMigration;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class Up
 * @package Vados\MigrationRunner\command
 */
class Up extends MigrationRun implements ICommand
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var int
     */
    private $runCount = 0;

    /**
     * Up constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        parent::__construct();
        $this->params = $params;
        if (array_key_exists(0, $params)) {
            $this->runCount = (int)$params[0];
        }
    }

    public function run()
    {
        $migrations = $this->getNewMigrations();
        if ($this->runCount !== 0) {
            $migrations = array_slice($migrations, 0, $this->runCount);
        }
        if (!empty($migrations)) {
            foreach ($migrations as $migration) {
                echo $migration . PHP_EOL;
            }
            if ($this->actionConfirmation('Apply the above migrations?')) {
                foreach ($migrations as $migration) {
                    echo "Migration $migration: ";
                    $result = $this->up($migration);
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
     * @param string $migration
     * @return bool
     */
    private function up(string $migration): bool
    {
        if (file_exists(PathProvider::getMigrationDir() . DIRECTORY_SEPARATOR . $migration)) {
            require_once PathProvider::getMigrationDir() . DIRECTORY_SEPARATOR . $migration;
            $migrationClass = substr($migration, 0, -4);
            /** @var Migration $m */
            $m = new $migrationClass();
            if ($m->safeRun('up')) {
                $model = new TblMigration();
                $model->setMigration($migration);
                $model->save();
                return true;
            }
        }
        return false;
    }
}