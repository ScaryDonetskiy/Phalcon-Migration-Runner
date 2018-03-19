<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 12:27
 */

namespace Vados\MigrationRunner\command;

/**
 * Interface ICommand
 * @package Vados\MigrationRunner\command
 */
interface ICommand
{
    public function run();
}