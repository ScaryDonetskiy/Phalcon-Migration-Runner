<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 12:58
 */

namespace Vados\MigrationRunner\command;

use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class Create
 * @package Vados\MigrationRunner\command
 */
class Create implements ICommand
{
    /**
     * @var array
     */
    private $params;

    /**
     * @var string
     */
    private $migrationName;

    /**
     * Create constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->migrationName = $params[0];
    }

    public function run()
    {
        if (!is_dir(PathProvider::getMigrationDir())) {
            mkdir(PathProvider::getMigrationDir());
        }
        $migrationFile = file_get_contents(__DIR__ . '/../migration/Template');
        $timestamp = time();
        $migrationFile = str_replace('{{timestamp}}', $timestamp, $migrationFile);
        $migrationFile = str_replace('{{migrationName}}', $this->migrationName, $migrationFile);
        $filename = PathProvider::getMigrationDir() . "/m{$timestamp}_{$this->migrationName}.php";
        file_put_contents($filename, $migrationFile);
        echo "Migration $filename created!" . PHP_EOL;
    }
}