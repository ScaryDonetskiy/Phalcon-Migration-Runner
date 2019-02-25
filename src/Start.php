<?php

namespace Vados\MigrationRunner;

use Phalcon\Db\Adapter\Pdo\Factory;
use Phalcon\Di;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\Model\MetaData\Memory;
use Vados\MigrationRunner\command\Create;
use Vados\MigrationRunner\command\Down;
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
        if (array_key_exists(1, $argv)) {
            $this->command = $argv[1];
        } else {
            $this->command = 'help';
        }
        $this->params = array_splice($argv, 2);
        $di = new Di();
        $di->setShared('db', function() {
            return Factory::load(require PathProvider::getConfig());
        });
        $di->set('modelsManager', new Manager());
        $di->set('modelsMetadata', new Memory());
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
            case Command::DOWN:
                (new Down($this->params))->run();
                break;
        }
    }
}