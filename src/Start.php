<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 12:18
 */

namespace Vados\MigrationRunner;

use Vados\MigrationRunner\command\Create;
use Vados\MigrationRunner\command\GenerateConfigWizard;
use Vados\MigrationRunner\command\Help;
use Vados\MigrationRunner\command\Up;
use Vados\MigrationRunner\enum\Command;
use Vados\MigrationRunner\providers\PathProvider;

/**
 * Class Start
 * @package Vados\MigrationRunner
 */
class Start
{
    /**
     * @var string
     */
    private $command;

    /**
     * @var array
     */
    private $params = [];

    /**
     * Start constructor.
     * @param array $argv
     */
    public function __construct(array $argv)
    {
        $this->command = $argv[1];
        $this->params = array_splice($argv, 2);
    }

    public function process() {
        if (!file_exists(PathProvider::getConfig())) {
            (new GenerateConfigWizard())->run();
        }
        switch ($this->command) {
            case Command::HELP:
                (new Help())->run();
                break;
            case Command::CREATE:
                (new Create($this->params))->run();
                break;
            case Command::UP:
                (new Up($this->params))->run();
                break;
        }
    }
}