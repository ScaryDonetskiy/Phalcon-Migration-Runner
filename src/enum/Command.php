<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 12:25
 */

namespace Vados\MigrationRunner\enum;

/**
 * Class Command
 * @package Vados\MigrationRunner\enum
 */
final class Command
{
    const HELP = 'help';
    const CREATE = 'create';
    const UP = 'up';
    const DOWN = 'down';
}