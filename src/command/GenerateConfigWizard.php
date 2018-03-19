<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 19.03.2018
 * Time: 21:46
 */

namespace Vados\MigrationRunner\command;

use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class GenerateConfigWizard
 * @package Vados\MigrationRunner\command
 */
class GenerateConfigWizard implements ICommand
{

    public function run()
    {
        $config = [];
        echo 'Enter database adapter (default: sqlite): ';
        $config['adapter'] = trim(fgets(STDIN));
        if (!$config['adapter']) {
            $config['adapter'] = 'sqlite';
        }
        if ($config['adapter'] !== 'sqlite') {
            echo 'Enter database host (default: localhost): ';
            $config['host'] = trim(fgets(STDIN));
            if (!$config['host']) {
                $config['host'] = 'localhost';
            }
            echo 'Enter username (default: root): ';
            $config['username'] = trim(fgets(STDIN));
            if (!$config['username']) {
                $config['username'] = 'root';
            }
            echo 'Enter password (default: root): ';
            $config['password'] = trim(fgets(STDIN));
            if (!$config['password']) {
                $config['password'] = 'root';
            }
        }
        echo 'Enter database name (default: phalcon): ';
        $config['dbname'] = trim(fgets(STDIN));
        if (!$config['dbname']) {
            $config['dbname'] = 'phalcon';
        }
        file_put_contents(PathProvider::getConfig(), '<?php return ' . var_export($config, true) . ';');
    }
}