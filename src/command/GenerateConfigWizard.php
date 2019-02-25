<?php

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
        $this->getFromStdin($config['adapter'], 'sqlite');
        if ('sqlite' !== $config['adapter']) {
            echo 'Enter database host (default: localhost): ';
            $this->getFromStdin($config['host'], 'localhost');
            echo 'Enter username (default: root): ';
            $this->getFromStdin($config['username'], 'root');
            echo 'Enter password (default: root): ';
            $this->getFromStdin($config['password'], 'root');
        }
        echo 'Enter database name (default: phalcon): ';
        $this->getFromStdin($config['dbname'], 'phalcon');
        file_put_contents(PathProvider::getConfig(), '<?php return ' . var_export($config, true) . ';');
        echo 'Config generated in ' . PathProvider::getConfig() . PHP_EOL;
    }

    /**
     * @var $field
     * @var $default
     */
    protected function getFromStdin(&$field, $default = null)
    {
        $field = trim(fgets(STDIN));
        if (!$field) {
            $field = $default;
        }
    }
}