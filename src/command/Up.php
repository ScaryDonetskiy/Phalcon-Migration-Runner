<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 13:39
 */

namespace Vados\MigrationRunner\command;

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
    private $runCount;

    /**
     * Up constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        parent::__construct();
        $this->params = $params;
        $this->runCount = (int)$params[0];
    }

    public function run()
    {

    }
}