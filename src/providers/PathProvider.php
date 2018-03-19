<?php
/**
 * Created by PhpStorm.
 * User: vladyslavpozdnyakov
 * Date: 17.03.2018
 * Time: 14:19
 */

namespace Vados\MigrationRunner\providers;

/**
 * Class PathProvider
 * @package Vados\MigrationRunner\providers
 */
class PathProvider
{
    /**
     * @return string
     */
    public static function getMigrationDir(): string
    {
        return getcwd() . '/migrations';
    }

    /**
     * @return string
     */
    public static function getConfig(): string
    {
        return getcwd() . '/migration_runner.config.php';
    }
}