<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 12:27
 */

namespace Vados\MigrationRunner\command;

/**
 * Class Help
 * @package Vados\MigrationRunner\command
 */
class Help implements ICommand
{
    public function run()
    {
        $text = <<<HELP
Available methods:
    - help - Show help information
    - create {name} - Create new migration
    - up {runCount=0} - Apply new migrations
    - down {runCount=1} - Revert some migration
HELP;
        echo $text . PHP_EOL;
    }
}